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

        // Disziplin finden
        $discipline = Discipline::findOrFail($validated['discipline_id']);

        // Schauen, ob in der Pivot-Tabelle schon Einträge existieren
        $existingPivot = $discipline->teams()
            ->where('team_id', $validated['team_id'])
            ->first();

        if ($existingPivot) {
            // Falls es existiert: gibt möglichkeit zu überschreibemn
            $discipline->teams()->updateExistingPivot(
                $validated['team_id'],
                ['score_1' => $validated['score_1'], 'score_2' => $validated['score_2']]
            );
        } else {
            // Falls nein: hinzufügen bzw einfügen
            $discipline->teams()->attach($validated['team_id'], [
                'score_1' => $validated['score_1'],
                'score_2' => $validated['score_2'],
            ]);
        }

        // sorgt dafür das beim drücken des buttons automatisch neu berechnet wird (wie bei Lehrer seite)
        $rankingController = new \App\Http\Controllers\RankingController();
        $rankingController->recalculateAllScores();

        return redirect()->back()->with('success', 'Werte gespeichert und Ranking automatisch aktualisiert!');
    }
}
