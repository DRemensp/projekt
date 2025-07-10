<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Services\SchoolColorService;
use PhpParser\Node\Stmt\Switch_;
use App\Models\Scoresystem;

class RankingController extends Controller
{
    public function index()
    {
        // Daten laden
        $schools = School::orderBy('score', 'DESC')->get();
        $klasses = Klasse::with('school')->orderBy('score', 'DESC')->get();
        $teams = Team::with(['disciplines', 'klasse.school'])->orderBy('score', 'DESC')->get();
        $disciplines = Discipline::with(['teams' => function($query) {
            $query->with('klasse.school');
        }])->get();

        // Bestes Team pro Disziplin
        $bestTeamsPerDiscipline = [];

        foreach ($disciplines as $discipline) {
            if ($discipline->teams->isEmpty()) continue;

            $bestTeam = null;
            $bestScore = null;

            // Durch alle Teams der Disziplin gehen
            foreach ($discipline->teams as $team) {
                $score1 = $team->pivot->score_1;
                $score2 = $team->pivot->score_2;

                // Besten Score des Teams ermitteln
                $teamBestScore = $this->getTeamBestScore($score1, $score2, $discipline->higher_is_better);

                if ($bestTeam === null || $this->isScoreBetter($teamBestScore, $bestScore, $discipline->higher_is_better)) {
                    $bestTeam = $team;
                    $bestScore = $teamBestScore;
                }
            }

            // Ergebnis hinzufügen
            if ($bestTeam && $bestScore !== null) {
                $bestTeamsPerDiscipline[] = [
                    'discipline_id' => $discipline->id,
                    'discipline_name' => $discipline->name,
                    'team_id' => $bestTeam->id,
                    'team_name' => $bestTeam->name,
                    'team_school_id' => $bestTeam->klasse->school_id ?? 0,
                    'best_score' => $bestScore,
                ];
            }
        }
        usort($bestTeamsPerDiscipline, fn($a, $b) => strcmp($a['discipline_name'], $b['discipline_name']));

        // für java suche
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


    private function getTeamBestScore($score1, $score2, $higherIsBetter)
    {
        if ($score1 === null && $score2 === null) return null; // Geändert von 0 zu null
        if ($score1 === null) return $score2;
        if ($score2 === null) return $score1;
        return $higherIsBetter ? max($score1, $score2) : min($score1, $score2);
    }


    private function isScoreBetter($newScore, $currentBestScore, $higherIsBetter)
    {
        // Neuer Score ist null = nie besser
        if ($newScore === null) return false;

        // Aktueller bester Score ist null = neuer ist automatisch besser
        if ($currentBestScore === null) return true;

        // Beide haben Werte = vergleichen
        return $higherIsBetter ? ($newScore > $currentBestScore) : ($newScore < $currentBestScore);
    }

    public function recalculateAllScores()
    {
        Team::query()->update(['score' => 0]);
        Klasse::query()->update(['score' => 0]);
        School::query()->update(['score' => 0]);

        $scoresystem = Scoresystem::all('first_place', 'second_place', 'third_place', 'score_step', 'max_score')->first();

        $disciplines = Discipline::with('teams:id')->get();

        foreach ($disciplines as $discipline) {
            if ($discipline->teams->isEmpty()) continue;
            $teamsScores = $discipline->teams->map(function ($team) use ($discipline, $scoresystem) {
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
                $teamId = $teamData['team_id'];
                if (isset($processedTeams[$teamId])) continue;

                switch ($platz) {
                    case 1:
                        $punkte = $scoresystem->first_place;
                        break;
                    case 2:
                        $punkte = $scoresystem->second_place;
                        break;
                    case 3:
                        $punkte = $scoresystem->third_place;
                        break;
                    default:
                        $punkte = max($scoresystem->max_score - ($platz - 4) * $scoresystem->score_step, 0);
                        break;
                }

                $updates[$teamId] = $punkte;
                $processedTeams[$teamId] = true;
                $platz++;
            }

            foreach ($updates as $teamId => $punkte) {
                Team::where('id', $teamId)->increment('score', $punkte);
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
