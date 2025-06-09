<?php

// app/Http/Controllers/TeamTableController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discipline;

class TeamTableController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'discipline_id' => 'required|exists:disciplines,id',
            'team_id'       => 'required|exists:teams,id',
            'score_1'       => 'nullable|numeric',
            'score_2'       => 'nullable|numeric',
        ]);

        // Disziplin laden
        $discipline = Discipline::findOrFail($validated['discipline_id']);

        // Schauen, ob in der Pivot-Tabelle schon Einträge existieren
        // (d.h. ob für diese Disziplin + Team bereits ein Datensatz angelegt ist)
        $existingPivot = $discipline->teams()
            ->where('team_id', $validated['team_id'])
            ->first();

        if ($existingPivot) {
            // Falls es existiert: updateExistingPivot
            $discipline->teams()->updateExistingPivot(
                $validated['team_id'],
                ['score_1' => $validated['score_1'], 'score_2' => $validated['score_2']]
            );
        } else {
            // Falls nein: attach
            $discipline->teams()->attach($validated['team_id'], [
                'score_1' => $validated['score_1'],
                'score_2' => $validated['score_2'],
            ]);
        }

        // *** NEU: Automatische Score-Neuberechnung ***
        $rankingController = new \App\Http\Controllers\RankingController();
        $rankingController->recalculateAllScores();

        return redirect()->back()->with('success', 'Werte gespeichert und Ranking automatisch aktualisiert!');
    }
}
