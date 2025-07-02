<?php

namespace App\Http\Controllers;


use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_name' => 'required|max:255',
            'klasse_id' => 'required|integer|exists:klasses,id',
        ]);

        //erlaubt das schreiben von mitglieder namen und Enter für Trennung
        $membersRaw = $request->input('members', ''); // Standard leer
        $membersArray = preg_split('/\r\n|\r|\n/', $membersRaw, -1, PREG_SPLIT_NO_EMPTY);

        Team::create([
            'klasse_id' => $validated['klasse_id'],
            'name'      => $validated['team_name'],
            'members'   => $membersArray, // wird als Array in der DB gespeichert
        ]);

        return redirect()->back()->with('success', 'Team created successfully.');
    }

    public function destroy(Team $team){
        $team->delete();
        return redirect()->back()->with('success', 'Team deleted successfully.');
    }
}
