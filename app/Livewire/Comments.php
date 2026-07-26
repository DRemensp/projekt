<?php

namespace App\Livewire;

use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\Setting;
use App\Services\PerspectiveService;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\On;
use Livewire\Component;

class Comments extends Component
{
    public $message;
    public $authorName;
    public $commentsToShow = 5;
    public array $shadowCommentIds = [];

    public function mount(): void
    {
        $raw = request()->cookie('shadow_comment_ids');
        if ($raw) {
            $ids = json_decode($raw, true);
            $this->shadowCommentIds = is_array($ids)
                ? array_values(array_filter($ids, 'is_int'))
                : [];
        }
    }

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

    #[On('echo:comments,.comment.posted')]
    public function refreshComments(): void
    {
        // Re-render wird automatisch ausgelöst
    }

    public function render()
    {
        // Defensiv: Die public Property wird bei Livewire-Updates aus dem Client-Payload
        // hydriert und kann dabei verschachtelte/ungültige Werte enthalten (manipulierte
        // oder veraltete Requests). Vor dem Query auf eine flache Integer-Liste reduzieren,
        // sonst wirft orWhereIn() "Nested arrays may not be passed to whereIn method".
        $shadowIds = collect(is_array($this->shadowCommentIds) ? $this->shadowCommentIds : [])
            ->filter(fn ($v) => is_int($v) || (is_string($v) && ctype_digit($v)))
            ->map(fn ($v) => (int) $v)
            ->unique()
            ->values()
            ->all();
        $this->shadowCommentIds = $shadowIds;

        $commentsQuery = Comment::where(function ($q) use ($shadowIds) {
            $q->where('moderation_status', 'approved');
            if (!empty($shadowIds)) {
                $q->orWhereIn('id', $shadowIds);
            }
        })->latest();

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

        // Rate-Limiting gegen Spam/Missbrauch: max. 5 Kommentare pro Minute je IP.
        $rateKey = 'comment-store:' . request()->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $seconds = RateLimiter::availableIn($rateKey);
            session()->flash('comment_blocked', "Zu viele Kommentare. Bitte warten Sie {$seconds} Sekunden.");
            return;
        }
        RateLimiter::hit($rateKey, 60);

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

            $comment = Comment::create([
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
                rescue(fn () => event(new CommentPosted()));
                session()->flash('comment_success', 'Kommentar erfolgreich hinzugefügt!');
            } elseif ($moderationStatus === 'pending') {
                session()->flash('comment_pending', 'Ihr Kommentar wird überprüft und dann freigeschaltet.');
            } else {
                // Shadow Ban: Nutzer denkt der Kommentar ist live
                $this->shadowCommentIds[] = $comment->id;
                Cookie::queue(
                    'shadow_comment_ids',
                    json_encode($this->shadowCommentIds),
                    60 * 24 * 30 // 30 Tage
                );
                session()->flash('comment_success', 'Kommentar erfolgreich hinzugefügt!');
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
