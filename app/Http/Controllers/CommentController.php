<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validierung des Kommentartexts
        $request->validate([
            'message' => 'required|string'
        ]);

        // Neuer Kommentar mit IP-Adresse anlegen
        Comment::create([
            'message'    => $request->input('message'),
            'ip_address' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'Kommentar wurde gespeichert.');
    }

    public function index()
    {
        $comments = Comment::all();

        return view('comments.index', compact('comments'));
    }


}
