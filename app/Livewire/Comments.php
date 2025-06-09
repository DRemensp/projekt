<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public $message;
    public $authorName;
    public $commentsToShow = 5; // Anzahl der anzuzeigenden Kommentare

    protected $rules = [
        'message' => 'required|string|max:200',
        'authorName' => 'nullable|string|max:50|regex:/^[a-zA-ZäöüÄÖÜß0-9\s\-_\.]+$/',
    ];

    protected $messages = [
        'message.required' => 'Bitte geben Sie eine Nachricht ein.',
        'message.max' => 'Die Nachricht darf maximal 200 Zeichen lang sein.',
        'authorName.max' => 'Der Name darf maximal 50 Zeichen lang sein.',
        'authorName.regex' => 'Der Name darf nur Buchstaben, Zahlen und grundlegende Sonderzeichen enthalten.',
    ];

    public function render()
    {
        $allComments = Comment::latest()->get();
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

        Comment::create([
            'message'     => $this->message,
            'author_name' => $this->authorName ?: 'Anonym',
            'ip_address'  => request()->ip(),
        ]);

        $this->message = '';
        $this->authorName = '';

        session()->flash('comment_success', 'Kommentar erfolgreich hinzugefügt!');
    }

    public function loadMore()
    {
        $this->commentsToShow += 5;
    }

    public function showLess()
    {
        $this->commentsToShow = 5;
    }
}
