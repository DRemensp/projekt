<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Setting;
use App\Services\PerspectiveService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Comments extends Component
{
    public $message;
    public $authorName;
    public $commentsToShow = 5;

    protected $rules = [
        'message' => 'required|string|max:150|regex:/^[^\r\n]*$/',
        'authorName' => "nullable|string|max:50|regex:/^[\\pL\\pN\\s\\._'\\-]*$/u",
    ];

    protected $messages = [
        'message.required' => 'Bitte geben Sie eine Nachricht ein.',
        'message.max' => 'Die Nachricht darf maximal 150 Zeichen lang sein.',
        'message.regex' => 'Zeilenumbrüche sind nicht erlaubt.',
        'authorName.max' => 'Der Name darf maximal 50 Zeichen lang sein.',
        'authorName.regex' => 'Der Name darf nur Buchstaben, Zahlen und grundlegende Sonderzeichen enthalten.',
    ];

    public function render()
    {
        $commentsQuery = Comment::approved()->latest();
        $totalComments = (clone $commentsQuery)->count();
        $visibleComments = $commentsQuery->take($this->commentsToShow)->get();

        return view('livewire.comments', [
            'comments' => $visibleComments,
            'totalComments' => $totalComments,
            'hasMoreComments' => $totalComments > $this->commentsToShow,
            'commentsEnabled' => Setting::commentsEnabled(),
        ]);
    }

    public function store()
    {
        if (!Setting::commentsEnabled()) {
            session()->flash('comment_blocked', 'Kommentare sind derzeit deaktiviert.');
            return;
        }

        // Serverseitige Durchsetzung: Kommentare nur mit Moderation-Consent + bestätigtem Hinweis.
        if (!$this->hasModerationConsent() || !$this->isFirstUseNoticeConfirmed()) {
            session()->flash('comment_blocked', 'Kommentare sind erst nach Einwilligung und Bestätigung des Hinweises möglich.');
            return;
        }

        $this->validate();

        try {
            $moderationService = new PerspectiveService();
            $analysis = $moderationService->analyzeText($this->message);

            Log::info('Comment moderation analysis', [
                'text' => substr($this->message, 0, 50) . '...',
                'analysis' => $analysis,
            ]);

            $moderationStatus = 'pending';
            $moderationReason = null;

            switch ($analysis['action']) {
                case 'allow':
                    $moderationStatus = 'approved';
                    break;

                case 'moderate':
                    $moderationStatus = 'pending';
                    $moderationReason = 'Automatisch zur manuellen Überprüfung markiert wegen: ' .
                        $moderationService->getReasonText($analysis);
                    break;

                case 'block':
                    $moderationStatus = 'blocked';
                    $moderationReason = 'Automatisch blockiert wegen: ' .
                        $moderationService->getReasonText($analysis);
                    break;
            }

            Comment::create([
                'message' => $this->message,
                'author_name' => $this->authorName ?: 'Anonym',
                'ip_address' => request()->ip(),
                'moderation_status' => $moderationStatus,
                'moderation_scores' => $analysis['scores'] ?? [],
                'moderation_reason' => $moderationReason,
                'moderated_at' => $moderationStatus !== 'pending' ? now() : null,
            ]);

            $this->message = '';
            $this->authorName = '';

            if ($moderationStatus === 'approved') {
                session()->flash('comment_success', 'Kommentar erfolgreich hinzugefügt!');
            } elseif ($moderationStatus === 'pending') {
                session()->flash('comment_pending', 'Ihr Kommentar wird überprüft und dann freigeschaltet.');
            } else {
                session()->flash('comment_blocked', 'Ihr Kommentar konnte nicht veröffentlicht werden. Bitte achten Sie auf einen respektvollen Umgangston.');
            }
        } catch (\Exception $e) {
            Log::error('Error storing comment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Fallback: Bei Fehlern zur manuellen Überprüfung.
            Comment::create([
                'message' => $this->message,
                'author_name' => $this->authorName ?: 'Anonym',
                'ip_address' => request()->ip(),
                'moderation_status' => 'pending',
                'moderation_reason' => 'Moderations-Service nicht verfügbar - manuelle Überprüfung erforderlich',
            ]);

            $this->message = '';
            $this->authorName = '';

            session()->flash('comment_pending', 'Ihr Kommentar wird überprüft und dann freigeschaltet.');
        }
    }

    private function hasModerationConsent(): bool
    {
        $rawConsent = request()->cookie(config('cookie-consent.cookie_name'));
        if (!$rawConsent) {
            return false;
        }

        $decoded = json_decode(rawurldecode($rawConsent), true);
        return is_array($decoded) && ($decoded['moderation'] ?? false) === true;
    }

    private function isFirstUseNoticeConfirmed(): bool
    {
        return request()->cookie('comment_notice_ack') === '1';
    }

    public function loadMore()
    {
        $this->commentsToShow += 5;
    }

    public function showLess()
    {
        $this->commentsToShow = 5;
    }

    public function destroy(Comment $comment)
    {
        if (!auth()->check()) {
            abort(403, 'Sie müssen eingeloggt sein, um Kommentare zu löschen');
        }

        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher')) {
            abort(403, 'Keine Berechtigung zum Löschen von Kommentaren');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Kommentar erfolgreich gelöscht!');
    }
}
