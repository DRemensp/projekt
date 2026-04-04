<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    private function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Keine Berechtigung');
        }
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'team_name' => 'required|max:255',
            'klasse_id' => 'required|integer|exists:klasses,id',
        ]);

        // Erlaubt das Schreiben von Mitgliedernamen und Enter für Trennung
        $membersRaw = $request->input('members', '');
        $membersArray = preg_split('/\r\n|\r|\n/', $membersRaw, -1, PREG_SPLIT_NO_EMPTY);

        Team::create([
            'klasse_id' => $validated['klasse_id'],
            'name' => $validated['team_name'],
            'members' => $membersArray,
        ]);

        return redirect()->back()->with('success', 'Team created successfully.');
    }

    public function destroy(Team $team)
    {
        $this->ensureAdmin();
        $team->delete();
        return redirect()->back()->with('success', 'Team deleted successfully.');
    }

    public function update(Request $request, Team $team)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'team_name' => 'required|max:255',
            'klasse_id' => 'required|integer|exists:klasses,id',
            'members' => 'nullable|string',
        ]);

        $membersRaw = $validated['members'] ?? '';
        $membersArray = preg_split('/\r\n|\r|\n/', $membersRaw, -1, PREG_SPLIT_NO_EMPTY);

        $team->update([
            'name' => $validated['team_name'],
            'klasse_id' => $validated['klasse_id'],
            'members' => $membersArray,
        ]);

        return redirect()->back()->with('success', 'Team erfolgreich aktualisiert.');
    }
}
