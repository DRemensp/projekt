<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Services\SchoolColorService;
use phpDocumentor\Reflection\Types\True_;
use PhpParser\Node\Stmt\Switch_;
use App\Models\Scoresystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        $viewData = Cache::remember('ranking_data', 300, function () {
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

                foreach ($discipline->teams as $team) {
                    $score1 = $team->pivot->score_1;
                    $score2 = $team->pivot->score_2;

                    $teamBestScore = $this->getTeamBestScore($score1, $score2, $discipline->higher_is_better);

                    if ($bestTeam === null || $this->isScoreBetter($teamBestScore, $bestScore, $discipline->higher_is_better)) {
                        $bestTeam = $team;
                        $bestScore = $teamBestScore;
                    }
                }

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

            // Detaillierte Rankings pro Disziplin für Modal
            $disciplineDetailsForJs = [];
            foreach ($disciplines as $discipline) {
                $teamsData = [];

                foreach ($discipline->teams as $team) {
                    $score1 = $team->pivot->score_1;
                    $score2 = $team->pivot->score_2;
                    $bestScore = $this->getTeamBestScore($score1, $score2, $discipline->higher_is_better);

                    if ($bestScore !== null) {
                        $teamsData[] = [
                            'team_name' => $team->name,
                            'klasse_name' => $team->klasse->name ?? 'N/A',
                            'school_id' => $team->klasse->school_id ?? 0,
                            'best_score' => $bestScore,
                        ];
                    }
                }

                if ($discipline->higher_is_better) {
                    usort($teamsData, fn($a, $b) => $b['best_score'] <=> $a['best_score']);
                } else {
                    usort($teamsData, fn($a, $b) => $a['best_score'] <=> $b['best_score']);
                }

                foreach ($teamsData as $index => $teamData) {
                    $teamsData[$index]['rank'] = $index + 1;
                }

                $disciplineDetailsForJs[$discipline->id] = [
                    'name' => $discipline->name,
                    'higher_is_better' => $discipline->higher_is_better,
                    'teams' => $teamsData,
                ];
            }

            // für JS-Suche
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

            return [
                'schools'                => $schools,
                'klasses'                => $klasses,
                'teams'                  => $teams,
                'bestTeamsPerDiscipline' => $bestTeamsPerDiscipline,
                'teamsForJs'             => $teamsForJs,
                'colorMapForJs'          => SchoolColorService::getAllColorsForJs(),
                'disciplineDetailsForJs' => $disciplineDetailsForJs,
            ];
        });

        return view('ranking', $viewData);
    }


    private function getTeamBestScore($score1, $score2, $higherIsBetter)
    {
        // Bei zeitbasierten Disziplinen (niedriger = besser) ist 0.0 kein gültiger Wert
        if (!$higherIsBetter) {
            if ($score1 !== null && $score1 == 0) $score1 = null;
            if ($score2 !== null && $score2 == 0) $score2 = null;
        }
        if ($score1 === null && $score2 === null) return null;
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
        Cache::forget('ranking_data');
        Cache::forget('laufzettel_index');

        Team::query()->update(['score' => 0]);
        Klasse::query()->update(['score' => 0]);
        School::query()->update(['score' => 0]);

        $scoresystem = Scoresystem::all('first_place', 'second_place', 'third_place', 'score_step', 'max_score', 'bonus_score', 'school_teams_override')->first();

        $disciplines = Discipline::with('teams:id')->get();

        foreach ($disciplines as $discipline) {
            if ($discipline->teams->isEmpty()) continue;

            $teamsScores = $discipline->teams->map(function ($team) use ($discipline, $scoresystem) {
                $score1 = $team->pivot->score_1;
                $score2 = $team->pivot->score_2;

                // Bei zeitbasierten Disziplinen (niedriger = besser) ist 0.0 kein gültiger Wert
                if (!$discipline->higher_is_better) {
                    if ($score1 !== null && $score1 == 0) $score1 = null;
                    if ($score2 !== null && $score2 == 0) $score2 = null;
                }

                // Wenn beide Scores null sind, kein Ergebnis für dieses Team
                if ($score1 === null && $score2 === null) {
                    return null; // Team hat nicht teilgenommen
                }

                $best_score = null;
                if ($discipline->higher_is_better) {
                    $best_score = max($score1 ?? -INF, $score2 ?? -INF);
                    // Wenn das Ergebnis -INF ist, bedeutet das keine gültigen Werte
                    if ($best_score === -INF) {
                        return null;
                    }
                } else {
                    $best_score = min($score1 ?? INF, $score2 ?? INF);
                    // Wenn das Ergebnis INF ist, bedeutet das keine gültigen Werte
                    if ($best_score === INF) {
                        return null;
                    }
                }

                return ['team_id' => $team->id, 'best_score' => $best_score];
            })->filter(fn($data) => $data !== null); // Nur Teams mit gültigen Ergebnissen

            $teamsScores = $discipline->higher_is_better ? $teamsScores->sortByDesc('best_score') : $teamsScores->sortBy('best_score');
            $platz = 1;
            $processedTeams = [];
            $updates = [];

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

        // Bonusscores für Teams mit bonus = true hinzufügen
        Team::where('bonus', true)->increment('score', $scoresystem->bonus_score);

        $klasses = Klasse::with(['teams' => fn($query) => $query->select('id', 'score', 'klasse_id')])->select('id', 'school_id')->get();
        foreach ($klasses as $klasse) {
            $teams = $klasse->teams;
            $teamCount = $teams->count();
            $totalScore = $teams->sum('score');
            $klasseScore = $teamCount > 0 ? (int)round($totalScore / $teamCount) : 0;
            Klasse::where('id', $klasse->id)->update(['score' => $klasseScore]);
        }

        // Anzahl Teams pro Schule für Schulwertung bestimmen
        $schoolTeamsLimit = $scoresystem->school_teams_override;
        if ($schoolTeamsLimit === null) {
            // Auto: kleinste Teamanzahl über alle Schulen
            $teamCountsPerSchool = \DB::table('schools')
                ->join('klasses', 'klasses.school_id', '=', 'schools.id')
                ->join('teams', 'teams.klasse_id', '=', 'klasses.id')
                ->select('schools.id', \DB::raw('count(teams.id) as team_count'))
                ->groupBy('schools.id')
                ->pluck('team_count', 'id');
            $schoolTeamsLimit = $teamCountsPerSchool->isNotEmpty() ? max(1, (int)$teamCountsPerSchool->min()) : 1;
        }

        $schools = School::with(['klasses.teams' => function ($query) {
            $query->select('id', 'klasse_id', 'score');
        }])->select('id')->get();
        foreach ($schools as $school) {
            $allTeamScores = collect();
            foreach ($school->klasses as $klasse) {
                foreach ($klasse->teams as $team) {
                    $allTeamScores->push($team->score);
                }
            }
            $topScores = $allTeamScores->sortDesc()->take($schoolTeamsLimit);
            $schoolScore = (int)$topScores->sum();
            School::where('id', $school->id)->update(['score' => $schoolScore]);
        }
        return redirect()->back()->with('success', 'Alle Scores wurden erfolgreich neu berechnet!');
    }
}
