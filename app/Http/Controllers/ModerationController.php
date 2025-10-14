<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index()
    {
        // Zugriffskontrolle: Nur Admin und Teacher
        if (!auth()->check()) {
            abort(403, 'Sie müssen eingeloggt sein');
        }

        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher')) {
            abort(403, 'Keine Berechtigung für die Moderation');
        }

        // Alle Kommentare mit allen Status (approved, pending, blocked)
        $comments = Comment::orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistiken
        $stats = [
            'total' => Comment::count(),
            'approved' => Comment::where('moderation_status', 'approved')->count(),
            'pending' => Comment::where('moderation_status', 'pending')->count(),
            'blocked' => Comment::where('moderation_status', 'blocked')->count(),
        ];

        return view('moderation.index', compact('comments', 'stats'));
    }

    public function destroy(Comment $comment)
    {
        // Zugriffskontrolle
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))) {
            abort(403, 'Keine Berechtigung');
        }

        $comment->delete();

        return redirect()->route('moderation.index')
            ->with('success', 'Kommentar erfolgreich gelöscht!');
    }

    public function approve(Comment $comment)
    {
        // Zugriffskontrolle
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))) {
            abort(403, 'Keine Berechtigung');
        }

        $comment->update([
            'moderation_status' => 'approved',
            'moderated_at' => now(),
        ]);

        return redirect()->route('moderation.index')
            ->with('success', 'Kommentar wurde freigegeben!');
    }

    public function block(Comment $comment)
    {
        // Zugriffskontrolle
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))) {
            abort(403, 'Keine Berechtigung');
        }

        $comment->update([
            'moderation_status' => 'blocked',
            'moderated_at' => now(),
        ]);

        return redirect()->route('moderation.index')
            ->with('success', 'Kommentar wurde blockiert!');
    }
}
