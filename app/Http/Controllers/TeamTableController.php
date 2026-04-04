<?php

// app/Http/Controllers/TeamTableController.php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\Team;
use App\Services\ActivityLogService;
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
        $discipline = Discipline::with('klasse')->findOrFail($validated['discipline_id']);
        $team       = Team::findOrFail($validated['team_id']);

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

        $wasNew  = $existingPivot === null;
        $oldScore1 = $existingPivot ? ($existingPivot->pivot->score_1 !== null ? (float) $existingPivot->pivot->score_1 : null) : null;
        $oldScore2 = $existingPivot ? ($existingPivot->pivot->score_2 !== null ? (float) $existingPivot->pivot->score_2 : null) : null;
        $newScore1 = $validated['score_1'] !== null ? (float) $validated['score_1'] : null;
        $newScore2 = $validated['score_2'] !== null ? (float) $validated['score_2'] : null;

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

        // Aktivität loggen
        app(ActivityLogService::class)->logScoreChanges(
            $user, $discipline, $team,
            $oldScore1, $oldScore2,
            $newScore1, $newScore2,
            $wasNew
        );

        // Ranking nach Speichern neu berechnen
        $rankingController = new \App\Http\Controllers\RankingController();
        $rankingController->recalculateAllScores();

        return redirect()->back()->with('success', 'Werte gespeichert und Ranking automatisch aktualisiert!');
    }
}
