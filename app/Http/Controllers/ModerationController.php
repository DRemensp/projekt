<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\Setting;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        // Zugriffskontrolle: Nur Admin und Teacher
        if (!auth()->check()) {
            abort(403, 'Sie müssen eingeloggt sein');
        }

        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher')) {
            abort(403, 'Keine Berechtigung für die Moderation');
        }

        $filterIp = $request->query('ip');

        $query = Comment::orderBy('created_at', 'desc');
        if ($filterIp) {
            $query->where('ip_address', $filterIp);
        }
        $comments = $query->paginate(20)->withQueryString();

        // Statistiken (gefiltert oder global)
        $statsBase = $filterIp
            ? Comment::where('ip_address', $filterIp)
            : Comment::query();

        $stats = [
            'total'    => (clone $statsBase)->count(),
            'approved' => (clone $statsBase)->where('moderation_status', 'approved')->count(),
            'pending'  => (clone $statsBase)->where('moderation_status', 'pending')->count(),
            'blocked'  => (clone $statsBase)->where('moderation_status', 'blocked')->count(),
        ];

        // Pro-IP Statistiken für Wiederholungstäter-Badge (nur in der Gesamtansicht)
        $ipStats = [];
        if (!$filterIp) {
            $ipStats = Comment::selectRaw('ip_address, COUNT(*) as total, SUM(moderation_status = "blocked") as blocked_count')
                ->groupBy('ip_address')
                ->get()
                ->keyBy('ip_address');
        }

        $commentsEnabled = Setting::commentsEnabled();

        return view('moderation.index', compact('comments', 'stats', 'commentsEnabled', 'filterIp', 'ipStats'));
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

        rescue(fn () => event(new CommentPosted()));

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

    public function toggleComments()
    {
        // Zugriffskontrolle
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))) {
            abort(403, 'Keine Berechtigung');
        }

        $isEnabled = Setting::toggleComments();

        $message = $isEnabled
            ? 'Kommentare wurden aktiviert!'
            : 'Kommentare wurden deaktiviert!';

        return redirect()->route('moderation.index')
            ->with('success', $message);
    }
}
