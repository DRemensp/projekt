<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public $message;
    public $showAllComments = false;

    protected $rules = [
        'message' => 'required|string|max:200',
    ];

    public function render()
    {
        $comments = Comment::latest()->get();
        return view('livewire.comments', [
            'comments' => $comments
        ]);
    }

    public function store()
    {
        $this->validate();

        Comment::create([
            'message'    => $this->message,
            'ip_address' => request()->ip(),
        ]);

        $this->message = '';
    }

    public function toggleShowAll()
    {
        $this->showAllComments = !$this->showAllComments;
    }
}
