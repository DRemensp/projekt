<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Services\SchoolColorService;

class RankingController extends Controller
{
    public function index()
    {
        // Daten laden
        $schools = School::orderBy('score', 'DESC')->get();
        $klasses = Klasse::with('school')->orderBy('score', 'DESC')->get();
        $teams = Team::with(['disciplines', 'klasse.school'])->orderBy('score', 'DESC')->get();
        $disciplines = Discipline::with('teams')->get();

        // Bestes Team pro Disziplin
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
                $score1 = $teamWithBestValue->pivot->score_1;
                $score2 = $teamWithBestValue->pivot->score_2;
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

        // Daten speziell für JavaScript-Suche vorbereiten
        $teamsForJs = $teams->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'score' => $team->score,
                'klasse_name' => $team->klasse->name ?? 'N/A',
                'school_name' => $team->klasse->school->name ?? '-',
                'school_id' => $team->klasse->school_id ?? 0,
                'disciplines_list' => $team->disciplines->count() > 0
                    ? $team->disciplines->pluck('name')->implode(', ')
                    : null,
            ];
        });

        // Farb-Map für JavaScript erstellen
        $colorMapForJs = SchoolColorService::getAllColorsForJs();

        return view('ranking', [
            'schools' => $schools,
            'klasses' => $klasses,
            'teams' => $teams,
            'bestTeamsPerDiscipline' => $bestTeamsPerDiscipline,
            'teamsForJs' => $teamsForJs,
            'colorMapForJs' => $colorMapForJs,
        ]);
    }

    public function recalculateAllScores()
    {
        Team::query()->update(['score' => 0]);
        Klasse::query()->update(['score' => 0]);
        School::query()->update(['score' => 0]);
        $disciplines = Discipline::with('teams:id')->get();
        foreach ($disciplines as $discipline) {
            if ($discipline->teams->isEmpty()) continue;
            $teamsScores = $discipline->teams->map(function ($team) use ($discipline) {
                $score1 = $team->pivot->score_1;
                $score2 = $team->pivot->score_2;
                $best_score = 0;
                if ($discipline->higher_is_better) {
                    $best_score = ($score1 === null && $score2 === null) ? 0 : max($score1 ?? -INF, $score2 ?? -INF);
                } else {
                    $temp_min = ($score1 === null && $score2 === null) ? INF : min($score1 ?? INF, $score2 ?? INF);
                    $best_score = ($temp_min === INF) ? 0 : $temp_min;
                }
                return ['team_id' => $team->id, 'best_score' => $best_score];
            })->filter(fn($data) => true);
            $teamsScores = $discipline->higher_is_better ? $teamsScores->sortByDesc('best_score') : $teamsScores->sortBy('best_score');
            $platz = 1;
            $processedTeams = [];
            foreach ($teamsScores as $teamData) {
                if (in_array($teamData['team_id'], $processedTeams)) continue;
                $punkte = max($discipline->max_score - ($platz - 1) * $discipline->score_step, 0);
                Team::where('id', $teamData['team_id'])->increment('score', $punkte);
                $processedTeams[] = $teamData['team_id'];
                $platz++;
            }
        }
        $klasses = Klasse::with(['teams' => fn($query) => $query->select('id', 'score', 'klasse_id')])->select('id', 'school_id')->get();
        foreach ($klasses as $klasse) {
            $teams = $klasse->teams;
            $teamCount = $teams->count();
            $totalScore = $teams->sum('score');
            $klasseScore = $teamCount > 0 ? (int)round($totalScore / $teamCount) : 0;
            Klasse::where('id', $klasse->id)->update(['score' => $klasseScore]);
        }
        $schools = School::with(['klasses' => function ($query) {
            $query->select('id', 'school_id', 'score')->withCount('teams')->withSum('teams', 'score');
        }])->select('id')->get();
        foreach ($schools as $school) {
            $totalTeamScoreSum = 0;
            $totalTeamCount = 0;
            foreach ($school->klasses as $klasse) {
                $totalTeamScoreSum += $klasse->teams_sum_score ?? 0;
                $totalTeamCount += $klasse->teams_count ?? 0;
            }
            $schoolScore = $totalTeamCount > 0 ? (int)round($totalTeamScoreSum / $totalTeamCount) : 0;
            School::where('id', $school->id)->update(['score' => $schoolScore]);
        }
        return redirect()->back()->with('success', 'Alle Scores wurden erfolgreich neu berechnet!');
    }
}
