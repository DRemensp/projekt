<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klasse;
use App\Models\Team;
use App\Models\Discipline;
use Illuminate\Http\Request; // Request wird aktuell nicht verwendet, kann aber bleiben

class RankingController extends Controller
{
    /**
     * Zeigt die Ranglisten an.
     * Die notwendigen Beziehungen werden hier per Eager Loading geladen,
     * um Performance-Probleme (N+1 Queries) im Blade-Template zu vermeiden.
     */
    public function index()
    {
        // --- Daten laden (wie in der optimierten Version) ---
        $schools = School::orderBy('score', 'DESC')->get();
        $klasses = Klasse::with('school')->orderBy('score', 'DESC')->get();
        $teams = Team::with(['disciplines', 'klasse.school'])->orderBy('score', 'DESC')->get();
        $disciplines = Discipline::with('teams')->get(); // Für 'Bestes Team' Sektion

        // --- 'Bestes Team pro Disziplin' Logik (wie in der optimierten Version) ---
        $bestTeamsPerDiscipline = [];
        foreach ($disciplines as $discipline) {
            if ($discipline->teams->isEmpty()) continue;
            $teamWithBestValue = $discipline->teams->reduce(function ($carry, $current) use ($discipline) {
                if (!$carry) return $current;
                $carryScore1 = $carry->pivot->score_1 ?? ($discipline->higher_is_better ? -INF : INF);
                $carryScore2 = $carry->pivot->score_2 ?? ($discipline->higher_is_better ? -INF : INF);
                $currentScore1 = $current->pivot->score_1 ?? ($discipline->higher_is_better ? -INF : INF);
                $currentScore2 = $current->pivot->score_2 ?? ($discipline->higher_is_better ? -INF : INF);
                if ($discipline->higher_is_better) {
                    $carryBest = max($carryScore1, $carryScore2);
                    $currentBest = max($currentScore1, $currentScore2);
                    return $currentBest > $carryBest ? $current : $carry;
                } else {
                    $carryBest = ($carry->pivot->score_1 === null && $carry->pivot->score_2 === null) ? INF : min($carryScore1, $carryScore2);
                    $currentBest = ($current->pivot->score_1 === null && $current->pivot->score_2 === null) ? INF : min($currentScore1, $currentScore2);
                    if ($carryBest === INF && $currentBest === INF) return $carry;
                    return $currentBest < $carryBest ? $current : $carry;
                }
            });
            if ($teamWithBestValue) {
                $score1 = $teamWithBestValue->pivot->score_1; $score2 = $teamWithBestValue->pivot->score_2;
                if ($discipline->higher_is_better) {
                    $bestValue = ($score1 === null && $score2 === null) ? 0 : max($score1 ?? -INF, $score2 ?? -INF);
                } else {
                    $bestValue = ($score1 === null && $score2 === null) ? 0 : min($score1 ?? INF, $score2 ?? INF);
                    if ($bestValue === INF) $bestValue = 0;
                }
                $bestTeamsPerDiscipline[] = [
                    'discipline_id' => $discipline->id, 'discipline_name' => $discipline->name,
                    'team_id' => $teamWithBestValue->id, 'team_name' => $teamWithBestValue->name,
                    'best_score' => $bestValue,
                ];
            }
        }
        usort($bestTeamsPerDiscipline, fn($a, $b) => strcmp($a['discipline_name'], $b['discipline_name']));


        // --- NEU: Daten speziell für JavaScript-Suche vorbereiten ---
        $teamsForJs = $teams->map(function($team) {
            return [
                'id'            => $team->id,
                'name'          => $team->name,
                'score'         => $team->score,
                'klasse_name'   => $team->klasse->name ?? 'N/A',
                'school_name'   => $team->klasse->school->name ?? '-', // Benötigt 'klasse.school' Eager Loading
                'school_id'     => $team->klasse->school_id ?? 0,      // Benötigt 'klasse' Eager Loading
                'disciplines_list' => $team->disciplines->count() > 0
                    ? $team->disciplines->pluck('name')->implode(', ') // Einfache Liste
                    : null,
            ];
        });

        // Hilfsfunktion, um Farbdefinitionen zu kapseln (könnte auch in einen Service etc.)
        $getSchoolColorClassesFunc = $this->getColorMappingFunction(); // Siehe neue Methode unten

        // Farb-Map für JavaScript erstellen
        $colorMapForJs = [
            'default' => $getSchoolColorClassesFunc(0),
            1 => $getSchoolColorClassesFunc(1),
            2 => $getSchoolColorClassesFunc(2),
            3 => $getSchoolColorClassesFunc(3),
            4 => $getSchoolColorClassesFunc(4),
            5 => $getSchoolColorClassesFunc(5),
            // Füge hier weitere IDs hinzu, falls nötig
        ];
        // --- ENDE: Daten für JavaScript vorbereiten ---


        // 7) Gibt die Daten an das View zurück
        return view('ranking', [
            'schools'               => $schools,
            'klasses'               => $klasses, // Hat ->school geladen
            'teams'                 => $teams,   // Wird für Top 3 etc. noch gebraucht
            'bestTeamsPerDiscipline'=> $bestTeamsPerDiscipline,
            // 'disciplines'           => $disciplines, // Nicht mehr zwingend nötig im View

            // NEU: Daten für JS übergeben
            'teamsForJs'            => $teamsForJs,
            'colorMapForJs'         => $colorMapForJs,
        ]);
    }

    /**
     * Berechnet alle Scores neu.
     * (Methode bleibt wie in der optimierten Version)
     */
    public function recalculateAllScores()
    {
        // ... (Komplette Logik aus der vorherigen optimierten Version hier einfügen) ...
        Team::query()->update(['score' => 0]);
        Klasse::query()->update(['score' => 0]);
        School::query()->update(['score' => 0]);
        $disciplines = Discipline::with('teams:id')->get();
        foreach ($disciplines as $discipline) { /* ... Punktvergabe ... */
            if ($discipline->teams->isEmpty()) continue;
            $teamsScores = $discipline->teams->map(function ($team) use ($discipline) {
                $score1 = $team->pivot->score_1; $score2 = $team->pivot->score_2;
                $best_score = 0;
                if ($discipline->higher_is_better) { $best_score = ($score1 === null && $score2 === null) ? 0 : max($score1 ?? -INF, $score2 ?? -INF); }
                else { $temp_min = ($score1 === null && $score2 === null) ? INF : min($score1 ?? INF, $score2 ?? INF); $best_score = ($temp_min === INF) ? 0 : $temp_min; }
                return ['team_id' => $team->id, 'best_score' => $best_score];
            })->filter(fn($data) => true);
            $teamsScores = $discipline->higher_is_better ? $teamsScores->sortByDesc('best_score') : $teamsScores->sortBy('best_score');
            $platz = 1; $processedTeams = [];
            foreach ($teamsScores as $teamData) {
                if (in_array($teamData['team_id'], $processedTeams)) continue;
                $punkte = max($discipline->max_score - ($platz - 1) * $discipline->score_step, 0);
                Team::where('id', $teamData['team_id'])->increment('score', $punkte);
                $processedTeams[] = $teamData['team_id']; $platz++;
            }
        }
        $klasses = Klasse::with(['teams' => fn ($query) => $query->select('id', 'score', 'klasse_id')])->select('id', 'school_id')->get();
        foreach ($klasses as $klasse) {
            $teams = $klasse->teams; $teamCount = $teams->count(); $totalScore = $teams->sum('score');
            $klasseScore = $teamCount > 0 ? (int) round($totalScore / $teamCount) : 0;
            Klasse::where('id', $klasse->id)->update(['score' => $klasseScore]);
        }
        $schools = School::with(['klasses' => function ($query) { $query->select('id', 'school_id', 'score')->withCount('teams')->withSum('teams', 'score'); }])->select('id')->get();
        foreach ($schools as $school) {
            $totalTeamScoreSum = 0; $totalTeamCount = 0;
            foreach ($school->klasses as $klasse) { $totalTeamScoreSum += $klasse->teams_sum_score ?? 0; $totalTeamCount += $klasse->teams_count ?? 0; }
            $schoolScore = $totalTeamCount > 0 ? (int) round($totalTeamScoreSum / $totalTeamCount) : 0;
            School::where('id', $school->id)->update(['score' => $schoolScore]);
        }
        return redirect()->back()->with('success', 'Alle Scores wurden erfolgreich neu berechnet!');
    }

    /**
     * Hilfsfunktion, um die Farbdefinitionen zentral zu halten.
     * Könnte auch in einen Helper oder Service ausgelagert werden.
     *
     * @return \Closure
     */
    protected function getColorMappingFunction(): \Closure
    {
        return function($schoolId) {
            // Standardfarben (Fallback)
            $defaultColors = [
                'text' => 'text-gray-700', 'border' => 'border-gray-500', 'bg' => 'bg-gray-50',
                'border-light' => 'border-gray-300', 'bg-light' => 'bg-gray-50/60',
                'text-subtle' => 'text-gray-600', 'text-points' => 'text-gray-800',
                'text-hover' => 'hover:text-gray-900', 'border-hover' => 'hover:border-gray-700'
            ];
            // Farben für spezifische School IDs
            $colors = [
                1 => ['text' => 'text-blue-700', 'border' => 'border-blue-500', 'bg' => 'bg-blue-50', 'border-light' => 'border-blue-300', 'bg-light' => 'bg-blue-50/60', 'text-subtle' => 'text-blue-600', 'text-points' => 'text-blue-800', 'text-hover' => 'hover:text-blue-900', 'border-hover' => 'hover:border-blue-700'],
                2 => ['text' => 'text-green-700', 'border' => 'border-green-500', 'bg' => 'bg-green-50', 'border-light' => 'border-green-300', 'bg-light' => 'bg-green-50/60', 'text-subtle' => 'text-green-600', 'text-points' => 'text-green-800', 'text-hover' => 'hover:text-green-900', 'border-hover' => 'hover:border-green-700'],
                3 => ['text' => 'text-purple-700', 'border' => 'border-purple-500', 'bg' => 'bg-purple-50', 'border-light' => 'border-purple-300', 'bg-light' => 'bg-purple-50/60', 'text-subtle' => 'text-purple-600', 'text-points' => 'text-purple-800', 'text-hover' => 'hover:text-purple-900', 'border-hover' => 'hover:border-purple-700'],
                4 => ['text' => 'text-amber-700', 'border' => 'border-amber-500', 'bg' => 'bg-amber-50', 'border-light' => 'border-amber-300', 'bg-light' => 'bg-amber-50/60', 'text-subtle' => 'text-amber-600', 'text-points' => 'text-amber-800', 'text-hover' => 'hover:text-amber-900', 'border-hover' => 'hover:border-amber-700'],
                5 => ['text' => 'text-rose-700', 'border' => 'border-rose-500', 'bg' => 'bg-rose-50', 'border-light' => 'border-rose-300', 'bg-light' => 'bg-rose-50/60', 'text-subtle' => 'text-rose-600', 'text-points' => 'text-rose-800', 'text-hover' => 'hover:text-rose-900', 'border-hover' => 'hover:border-rose-700'],
            ];
            return $colors[$schoolId] ?? $defaultColors;
        };
    }
}
