<?php

// app/Http/Controllers/TeamTableController.php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Klasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamTableController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'discipline_id' => 'required|exists:disciplines,id',
            'team_id' => 'required|exists:teams,id',
            'score_1' => 'nullable|numeric',
            'score_2' => 'nullable|numeric',
        ]);

        // Disziplin finden
        $discipline = Discipline::findOrFail($validated['discipline_id']);

        // Klassen-Accounts duerfen nur ihre eigene Disziplin bewerten.
        // Teacher/Admin behalten die globale Eingabe.
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('teacher')) {
            $klasse = Klasse::where('name', $user->name)->first();

            if (!$klasse || (int) $discipline->klasse_id !== (int) $klasse->id) {
                return redirect()->back()->with('error', 'Keine Berechtigung fuer diese Disziplin.');
            }
        }

        // Schauen, ob in der Pivot-Tabelle schon Eintraege existieren
        $existingPivot = $discipline->teams()
            ->where('team_id', $validated['team_id'])
            ->first();

        if ($existingPivot) {
            // Falls es existiert: Ueberschreiben
            $discipline->teams()->updateExistingPivot(
                $validated['team_id'],
                ['score_1' => $validated['score_1'], 'score_2' => $validated['score_2']]
            );
        } else {
            // Falls nein: neu anlegen
            $discipline->teams()->attach($validated['team_id'], [
                'score_1' => $validated['score_1'],
                'score_2' => $validated['score_2'],
            ]);
        }

        // Ranking nach Speichern neu berechnen
        $rankingController = new \App\Http\Controllers\RankingController();
        $rankingController->recalculateAllScores();

        return redirect()->back()->with('success', 'Werte gespeichert und Ranking automatisch aktualisiert!');
    }
}
