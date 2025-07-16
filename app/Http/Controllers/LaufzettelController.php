<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Discipline;
use App\Services\SchoolColorService;
use Illuminate\Http\Request;

class LaufzettelController extends Controller
{
    public function index()
    {
        // Lade alle Teams mit Schuldaten
        $teams = Team::with(['klasse.school'])->orderBy('name')->get();

        // Teams für die JavaScript Suche aufbereiten
        $jsTeams = [];
        foreach ($teams as $team) {
            $jsTeams[] = [
                'id' => $team->id,
                'name' => $team->name,
                'klasse_name' => $team->klasse ? $team->klasse->name : 'N/A',
                'school_name' => ($team->klasse && $team->klasse->school) ? $team->klasse->school->name : '-',
                'school_id' => $team->klasse ? $team->klasse->school_id : 0,
                'bonus' => $team->bonus, // Bonus-Status hinzufügen
            ];
        }

        // Farben für JS laden
        $jsColors = SchoolColorService::getAllColorsForJs();

        // Prüfen ob der User ein Admin ist
        $isAdmin = auth()->check() && auth()->user()->hasRole('admin');

        return view('laufzettel', [
            'selectedTeam' => null,
            'teamResults' => [],
            'teamsForJs' => $jsTeams,
            'colorMapForJs' => $jsColors,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function show($teamId)
    {
        // Das gewählte Team mit allen nötigen Relationen laden
        $team = Team::with(['klasse.school', 'disciplines'])->findOrFail($teamId);

        // Alle Teams für die Suche laden
        $allTeams = Team::with(['klasse.school'])->orderBy('name')->get();

        // Teams für JavaScript vorbereiten
        $teamList = [];
        foreach ($allTeams as $t) {
            $teamList[] = [
                'id' => $t->id,
                'name' => $t->name,
                'klasse_name' => $t->klasse ? $t->klasse->name : 'N/A',
                'school_name' => ($t->klasse && $t->klasse->school) ? $t->klasse->school->name : '-',
                'school_id' => $t->klasse ? $t->klasse->school_id : 0,
                'bonus' => $t->bonus, // Bonus-Status hinzufügen
            ];
        }

        // Gesamtplatzierung berechnen
        $allTeamsForRanking = Team::orderBy('score', 'DESC')->get();
        $overallRanking = null;
        $totalTeams = $allTeamsForRanking->count();

        foreach ($allTeamsForRanking as $index => $rankingTeam) {
            if ($rankingTeam->id == $team->id) {
                $overallRanking = $index + 1;
                break;
            }
        }

        // Alle Disziplinen mit Teams laden
        $allDisciplines = Discipline::with('teams')->get();

        $results = [];

        // Durch jede Disziplin gehen
        foreach ($allDisciplines as $disziplin) {
            // Teams der Disziplin verarbeiten
            $participatingTeams = [];

            foreach ($disziplin->teams as $teamInDisc) {
                $ergebnis1 = $teamInDisc->pivot->score_1;
                $ergebnis2 = $teamInDisc->pivot->score_2;

                // Bestes Ergebnis ermitteln
                $bestResult = null;
                if ($disziplin->higher_is_better) {
                    // Bei "höher ist besser"
                    if ($ergebnis1 !== null || $ergebnis2 !== null) {
                        $bestResult = max($ergebnis1 ?? -999999, $ergebnis2 ?? -999999);
                    }
                } else {
                    // Bei "niedriger ist besser"
                    if ($ergebnis1 !== null || $ergebnis2 !== null) {
                        $temp = min($ergebnis1 ?? 999999, $ergebnis2 ?? 999999);
                        $bestResult = ($temp == 999999) ? null : $temp;
                    }
                }

                // Nur Teams mit Ergebnissen
                if ($ergebnis1 !== null || $ergebnis2 !== null) {
                    $participatingTeams[] = [
                        'team_id' => $teamInDisc->id,
                        'best_score' => $bestResult,
                        'score_1' => $ergebnis1,
                        'score_2' => $ergebnis2,
                        'has_results' => true
                    ];
                }
            }

            // Teams sortieren für Ranking
            if ($disziplin->higher_is_better) {
                usort($participatingTeams, function($a, $b) {
                    return $b['best_score'] <=> $a['best_score'];
                });
            } else {
                usort($participatingTeams, function($a, $b) {
                    return $a['best_score'] <=> $b['best_score'];
                });
            }

            // Rekord der Disziplin finden
            $record = null;
            if (count($participatingTeams) > 0) {
                $record = $disziplin->higher_is_better
                    ? max(array_column($participatingTeams, 'best_score'))
                    : min(array_column($participatingTeams, 'best_score'));
            }

            // Position und Daten des aktuellen Teams ermitteln
            $position = null;
            $teamData = null;
            $teilgenommen = false;

            // Prüfen ob unser Team teilgenommen hat
            $teamInThisDiscipline = null;
            foreach ($disziplin->teams as $t) {
                if ($t->id == $team->id) {
                    $teamInThisDiscipline = $t;
                    break;
                }
            }

            if ($teamInThisDiscipline) {
                $s1 = $teamInThisDiscipline->pivot->score_1;
                $s2 = $teamInThisDiscipline->pivot->score_2;

                if ($s1 !== null || $s2 !== null) {
                    $teilgenommen = true;

                    // Bestes Ergebnis für unser Team
                    $teamBest = null;
                    if ($disziplin->higher_is_better) {
                        $teamBest = max($s1 ?? -999999, $s2 ?? -999999);
                    } else {
                        $temp = min($s1 ?? 999999, $s2 ?? 999999);
                        $teamBest = ($temp == 999999) ? null : $temp;
                    }

                    $teamData = [
                        'score_1' => $s1,
                        'score_2' => $s2,
                        'best_score' => $teamBest
                    ];

                    // Position finden
                    $pos = 1;
                    foreach ($participatingTeams as $participatingTeam) {
                        if ($participatingTeam['team_id'] == $team->id) {
                            $position = $pos;
                            break;
                        }
                        $pos++;
                    }
                }
            }

            $results[] = [
                'discipline_name' => $disziplin->name,
                'discipline_unit' => $disziplin->unit ?? '',
                'higher_is_better' => $disziplin->higher_is_better,
                'position' => $position,
                'scores' => $teamData,
                'has_participated' => $teilgenommen,
                'total_participants' => count($participatingTeams),
                'highscore' => $record
            ];
        }

        // Farben für die Schule laden
        $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0);

        // JavaScript Farben
        $jsColors = SchoolColorService::getAllColorsForJs();

        // Prüfen ob der User ein Admin ist
        $isAdmin = auth()->check() && auth()->user()->hasRole('admin');

        return view('laufzettel', [
            'selectedTeam' => $team,
            'teamResults' => $results,
            'schoolColors' => $colors,
            'teamsForJs' => $teamList,
            'colorMapForJs' => $jsColors,
            'overallRanking' => $overallRanking,
            'totalTeams' => $totalTeams,
            'isAdmin' => $isAdmin,
        ]);
    }

    /**
     * Toggle bonus status for a team (nur für Admins)
     */
    public function toggleBonus(Request $request, Team $team)
    {
        // Prüfen ob der User ein Admin ist
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Keine Berechtigung'
            ], 403);
        }

        $team->bonus = !$team->bonus;
        $team->save();

        // Ranking automatisch neu berechnen (wie bei TeacherController und Dashboard)
        $rankingController = new \App\Http\Controllers\RankingController();
        $rankingController->recalculateAllScores();

        return response()->json([
            'success' => true,
            'bonus' => $team->bonus,
            'message' => 'Bonus-Status erfolgreich aktualisiert und Ranking automatisch neu berechnet'
        ]);
    }

}
