<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Services\SchoolColorService;
use App\Models\Scoresystem;

class RankingController extends Controller
{
    public function index()
    {
        // Daten laden - Select nur benötigte Felder
        $schools = School::select('id', 'name', 'score')->orderBy('score', 'DESC')->get();
        $klasses = Klasse::with('school:id,name')->select('id', 'name', 'score', 'school_id')->orderBy('score', 'DESC')->get();
        $teams = Team::with(['disciplines:id,name', 'klasse.school:id,name'])
            ->select('id', 'name', 'score', 'klasse_id')
            ->orderBy('score', 'DESC')
            ->get();
        $disciplines = Discipline::with(['teams' => function($query) {
            $query->with('klasse.school:id,name')->select('teams.id', 'teams.name', 'teams.klasse_id');
        }])->select('id', 'name', 'higher_is_better')->get();

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

        // Detaillierte Rankings pro Disziplin für Modal
        $disciplineDetailsForJs = [];
        foreach ($disciplines as $discipline) {
            $teamsData = [];

            foreach ($discipline->teams as $team) {
                $score1 = $team->pivot->score_1;
                $score2 = $team->pivot->score_2;
                $bestScore = $this->getTeamBestScore($score1, $score2, $discipline->higher_is_better);

                // Nur Teams die teilgenommen haben (bestScore nicht null)
                if ($bestScore !== null) {
                    $teamsData[] = [
                        'team_name' => $team->name,
                        'klasse_name' => $team->klasse->name ?? 'N/A',
                        'school_id' => $team->klasse->school_id ?? 0,
                        'best_score' => $bestScore,
                    ];
                }
            }

            // Sortieren nach Score
            if ($discipline->higher_is_better) {
                usort($teamsData, fn($a, $b) => $b['best_score'] <=> $a['best_score']);
            } else {
                usort($teamsData, fn($a, $b) => $a['best_score'] <=> $b['best_score']);
            }

            // Platzierung hinzufügen
            foreach ($teamsData as $index => $teamData) {
                $teamsData[$index]['rank'] = $index + 1;
            }

            $disciplineDetailsForJs[$discipline->id] = [
                'name' => $discipline->name,
                'higher_is_better' => $discipline->higher_is_better,
                'teams' => $teamsData,
            ];
        }

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
            'disciplineDetailsForJs' => $disciplineDetailsForJs,
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

        $scoresystem = Scoresystem::all('first_place', 'second_place', 'third_place', 'score_step', 'max_score', 'bonus_score')->first();

        $disciplines = Discipline::with('teams:id')->get();

        foreach ($disciplines as $discipline) {
            if ($discipline->teams->isEmpty()) continue;

            $teamsScores = $discipline->teams->map(function ($team) use ($discipline, $scoresystem) {
                $score1 = $team->pivot->score_1;
                $score2 = $team->pivot->score_2;

                // Wenn beide Scores null sind, kein Ergebnis für dieses Team
                if ($score1 === null && $score2 === null) {
                    return null; // Team hat nicht teilgenommen
                }


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

                $punkte = match ($platz) {
                    1 => $scoresystem->first_place,
                    2 => $scoresystem->second_place,
                    3 => $scoresystem->third_place,
                    default => max($scoresystem->max_score - ($platz - 4) * $scoresystem->score_step, 0),
                };

                $updates[$teamId] = $punkte;
                $processedTeams[$teamId] = true;
                $platz++;
            }

            foreach ($updates as $teamId => $punkte) {
                Team::where('id', $teamId)->increment('score', $punkte);
            }
        }

        // Bonusscores für Teams mit bonus = true hinzufügen
        $bonusTeams = Team::where('bonus', true)->get();
        foreach ($bonusTeams as $team) {
            Team::where('id', $team->id)->increment('score', $scoresystem->bonus_score);
        }

        $klasses = Klasse::with(['teams' => fn($query) => $query->select('id', 'score', 'klasse_id')])->select('id', 'school_id')->get();
        foreach ($klasses as $klasse) {
            $teams = $klasse->teams;
            $teamCount = $teams->count();
            $totalScore = $teams->sum('score');
            $klasseScore = $teamCount > 0 ? (int)round($totalScore / $teamCount) : 0;
            Klasse::where('id', $klasse->id)->update(['score' => $klasseScore]);
        }

        // Schulen-Scores berechnen mit Füller-Teams-Logik
        $this->calculateSchoolScoresWithFillers();

        return redirect()->back()->with('success', 'Alle Scores wurden erfolgreich neu berechnet!');
    }

    /**
     * Berechnet Schulen-Scores mit Füller-Teams-Logik
     *
     * Schulen mit < 3 Teams bekommen Füller-Teams von anderen Schulen:
     * - Nur Platz 2 & 3 Teams von anderen Schulen (nie Platz 1)
     * - Füller-Teams dürfen nicht besser sein als das beste eigene Team
     * - 5 Durchläufe mit zufälligen Füller-Teams, Durchschnitt wird berechnet
     * - Füller-Teams werden NUR bei der Ziel-Schule verwendet, Original-Schulen unverändert
     */
    private function calculateSchoolScoresWithFillers()
    {
        // Alle Schulen mit ihren Top 3 Teams holen
        $schools = School::select('id')->get();
        $schoolTeamsData = [];

        foreach ($schools as $school) {
            $topTeams = Team::select('id', 'score', 'klasse_id')
                ->whereHas('klasse', function($query) use ($school) {
                    $query->where('school_id', $school->id);
                })
                ->orderBy('score', 'desc')
                ->limit(3)
                ->get();

            $schoolTeamsData[$school->id] = [
                'teams' => $topTeams->pluck('score')->toArray(),
                'team_count' => $topTeams->count(),
            ];
        }

        // Für jede Schule den Score berechnen
        $schoolScoreUpdates = [];

        foreach ($schoolTeamsData as $schoolId => $data) {
            $teamCount = $data['team_count'];
            $teams = $data['teams'];

            if ($teamCount >= 3) {
                // Schule hat 3+ Teams: normaler Durchschnitt der Top 3
                $schoolScoreUpdates[$schoolId] = (int)round(array_sum(array_slice($teams, 0, 3)) / 3);
            } else if ($teamCount > 0) {
                // Schule hat 1-2 Teams: 5x Zufallsverfahren NUR für diese Schule
                $neededFillers = 3 - $teamCount;
                $bestOwnTeamScore = max($teams);

                // Füller-Teams-Pool erstellen (Platz 2 & 3 von allen anderen Schulen)
                $availableFillers = [];
                foreach ($schoolTeamsData as $otherSchoolId => $otherData) {
                    if ($otherSchoolId === $schoolId) continue; // Nicht eigene Schule
                    if ($otherData['team_count'] < 2) continue; // Andere Schule muss mind. 2 Teams haben

                    $otherTeams = $otherData['teams'];

                    // Platz 2 hinzufügen (wenn nicht besser als eigenes bestes Team)
                    if (isset($otherTeams[1]) && $otherTeams[1] <= $bestOwnTeamScore) {
                        $availableFillers[] = $otherTeams[1];
                    }

                    // Platz 3 hinzufügen (wenn vorhanden und nicht besser als eigenes bestes Team)
                    if (isset($otherTeams[2]) && $otherTeams[2] <= $bestOwnTeamScore) {
                        $availableFillers[] = $otherTeams[2];
                    }
                }

                if (empty($availableFillers)) {
                    // Keine passenden Füller-Teams gefunden: nur eigene Teams verwenden
                    $schoolScoreUpdates[$schoolId] = (int)round(array_sum($teams) / $teamCount);
                } else {
                    // DETERMINISTISCHER ANSATZ: Verwende Median der verfügbaren Füller-Teams
                    // Kein Zufall = immer gleicher Wert bei gleichen Daten

                    sort($availableFillers); // Sortiert aufsteigend
                    $fillerCount = count($availableFillers);

                    // Median des Füller-Pools berechnen
                    if ($fillerCount % 2 == 0) {
                        $medianFiller = ($availableFillers[$fillerCount/2 - 1] + $availableFillers[$fillerCount/2]) / 2;
                    } else {
                        $medianFiller = $availableFillers[floor($fillerCount/2)];
                    }

                    // Fülle mit Median-Wert auf
                    $filledTeams = $teams;
                    for ($i = 0; $i < $neededFillers; $i++) {
                        $filledTeams[] = $medianFiller;
                    }

                    // Durchschnitt der Top 3 berechnen
                    rsort($filledTeams);
                    $schoolScoreUpdates[$schoolId] = (int)round(array_sum(array_slice($filledTeams, 0, 3)) / 3);
                }
            } else {
                // Schule hat keine Teams
                $schoolScoreUpdates[$schoolId] = 0;
            }
        }

        // Bulk-Update aller Schulen-Scores
        if (!empty($schoolScoreUpdates)) {
            $cases = [];
            $ids = [];
            foreach ($schoolScoreUpdates as $id => $score) {
                $cases[] = "WHEN {$id} THEN {$score}";
                $ids[] = $id;
            }
            $idsString = implode(',', $ids);
            $casesString = implode(' ', $cases);
            \DB::update("UPDATE schools SET score = CASE id {$casesString} END WHERE id IN ({$idsString})");
        }
    }
}
