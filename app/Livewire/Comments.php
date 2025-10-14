<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Services\PerspectiveService;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Comments extends Component
{
    public $message;
    public $authorName;
    public $commentsToShow = 5; // Anzahl der anzuzeigenden Kommentare

    protected $rules = [
        'message' => 'required|string|max:150|regex:/^[^\\r\\n]*$/',
        'authorName' => 'nullable|string|max:10',
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
        // Zeige nur genehmigte Kommentare an
        $allComments = Comment::approved()->latest()->get();
        $visibleComments = $allComments->take($this->commentsToShow);

        return view('livewire.comments', [
            'comments' => $visibleComments,
            'totalComments' => $allComments->count(),
            'hasMoreComments' => $allComments->count() > $this->commentsToShow
        ]);
    }

    public function store()
    {
        $this->validate();

        try {
            // Erstelle PerspectiveService
            $moderationService = new PerspectiveService();

            // Analysiere den Kommentar
            $analysis = $moderationService->analyzeText($this->message);

            // Log die Analyse für Debugging
            Log::info('Comment moderation analysis', [
                'text' => substr($this->message, 0, 50) . '...',
                'analysis' => $analysis
            ]);

            $moderationStatus = 'pending';
            $moderationReason = null;

            // Entscheide basierend auf der AI-Analyse
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

            // Erstelle den Kommentar
            $comment = Comment::create([
                'message' => $this->message,
                'author_name' => $this->authorName ?: 'Anonym',
                'ip_address' => request()->ip(),
                'moderation_status' => $moderationStatus,
                'moderation_scores' => $analysis['scores'],
                'moderation_reason' => $moderationReason,
                'moderated_at' => $moderationStatus !== 'pending' ? now() : null,
            ]);

            // Setze Eingabefelder zurück
            $this->message = '';
            $this->authorName = '';

            // Zeige passende Nachricht basierend auf Moderation
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
                'trace' => $e->getTraceAsString()
            ]);

            // Fallback: Bei Fehlern direkt genehmigen (oder zur manuellen Überprüfung)
            Comment::create([
                'message' => $this->message,
                'author_name' => $this->authorName ?: 'Anonym',
                'ip_address' => request()->ip(),
                'moderation_status' => 'pending', // Sicherheitshalber zur manuellen Überprüfung
                'moderation_reason' => 'Moderations-Service nicht verfügbar - manuelle Überprüfung erforderlich',
            ]);

            $this->message = '';
            $this->authorName = '';

            session()->flash('comment_pending', 'Ihr Kommentar wird überprüft und dann freigeschaltet.');
        }
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
        // Prüfe ob User eingeloggt ist
        if (!auth()->check()) {
            abort(403, 'Sie müssen eingeloggt sein, um Kommentare zu löschen');
        }

        // Nur Admin und Teacher dürfen löschen
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher')) {
            abort(403, 'Keine Berechtigung zum Löschen von Kommentaren');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Kommentar erfolgreich gelöscht!');
    }
}
