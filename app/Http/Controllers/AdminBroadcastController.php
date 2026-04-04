<?php

namespace App\Http\Controllers;

use App\Events\AdminBroadcastMessage;
use Illuminate\Http\Request;

class AdminBroadcastController extends Controller
{
    public function store(Request $request)
    {
        if (! $request->user() || ! $request->user()->hasRole('admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
            'targets' => ['required', 'array', 'min:1'],
            'targets.*' => ['in:teachers,klasses,guests'],
        ]);

        event(new AdminBroadcastMessage($validated['message'], $validated['targets']));

        return back()->with('success', 'Nachricht wurde gesendet.');
    }
}
