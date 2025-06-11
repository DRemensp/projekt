<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Discipline;
use App\Services\SchoolColorService;

class LaufzettelController extends Controller
{
    public function index()
    {
        // Teams für JavaScript-Suche vorbereiten
        $teams = Team::with(['klasse.school'])->orderBy('name')->get();

        $teamsForJs = $teams->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'klasse_name' => $team->klasse->name ?? 'N/A',
                'school_name' => $team->klasse->school->name ?? '-',
                'school_id' => $team->klasse->school_id ?? 0,
            ];
        });

        // Farb-Map für JavaScript erstellen
        $colorMapForJs = SchoolColorService::getAllColorsForJs();

        return view('laufzettel', [
            'selectedTeam' => null,
            'teamResults' => [],
            'teamsForJs' => $teamsForJs,
            'colorMapForJs' => $colorMapForJs,
        ]);
    }

    public function show($teamId)
    {
        // Ausgewähltes Team laden
        $selectedTeam = Team::with(['klasse.school', 'disciplines'])->findOrFail($teamId);

        // Teams für JavaScript-Suche vorbereiten
        $teams = Team::with(['klasse.school'])->orderBy('name')->get();

        $teamsForJs = $teams->map(function ($team) {
            return [
                'id' => $team->id,
                'name' => $team->name,
                'klasse_name' => $team->klasse->name ?? 'N/A',
                'school_name' => $team->klasse->school->name ?? '-',
                'school_id' => $team->klasse->school_id ?? 0,
            ];
        });

        // Alle Disziplinen laden
        $disciplines = Discipline::with('teams')->get();

        $teamResults = [];

        foreach ($disciplines as $discipline) {
            // Alle Teams in dieser Disziplin mit ihren Scores
            $teamsInDiscipline = $discipline->teams->map(function ($team) use ($discipline) {
                $score1 = $team->pivot->score_1;
                $score2 = $team->pivot->score_2;

                // Besten Score berechnen
                if ($discipline->higher_is_better) {
                    $bestScore = ($score1 === null && $score2 === null) ? null : max($score1 ?? -INF, $score2 ?? -INF);
                } else {
                    if ($score1 === null && $score2 === null) {
                        $bestScore = null;
                    } else {
                        $bestScore = min($score1 ?? INF, $score2 ?? INF);
                        if ($bestScore === INF) $bestScore = null;
                    }
                }

                return [
                    'team_id' => $team->id,
                    'best_score' => $bestScore,
                    'score_1' => $score1,
                    'score_2' => $score2,
                    'has_scores' => $score1 !== null || $score2 !== null
                ];
            })->filter(function ($teamData) {
                return $teamData['has_scores']; // Nur Teams mit Scores für Ranking
            });

            // Nach bestem Score sortieren (für Platzierung)
            $sortedTeams = $discipline->higher_is_better
                ? $teamsInDiscipline->sortByDesc('best_score')
                : $teamsInDiscipline->sortBy('best_score');

            // Highscore (beste Leistung aller Teams) berechnen
            $highscore = null;
            if ($teamsInDiscipline->count() > 0) {
                if ($discipline->higher_is_better) {
                    $highscore = $teamsInDiscipline->max('best_score');
                } else {
                    $highscore = $teamsInDiscipline->min('best_score');
                }
            }

            // Platzierung des ausgewählten Teams finden
            $teamPosition = null;
            $teamScores = null;
            $hasParticipated = false;

            // Zuerst prüfen, ob das Team überhaupt teilgenommen hat
            $teamInDiscipline = $discipline->teams->where('id', $selectedTeam->id)->first();
            if ($teamInDiscipline) {
                $score1 = $teamInDiscipline->pivot->score_1;
                $score2 = $teamInDiscipline->pivot->score_2;
                $hasParticipated = $score1 !== null || $score2 !== null;

                if ($hasParticipated) {
                    // Besten Score für dieses Team berechnen
                    if ($discipline->higher_is_better) {
                        $teamBestScore = max($score1 ?? -INF, $score2 ?? -INF);
                    } else {
                        $teamBestScore = min($score1 ?? INF, $score2 ?? INF);
                        if ($teamBestScore === INF) $teamBestScore = null;
                    }

                    $teamScores = [
                        'score_1' => $score1,
                        'score_2' => $score2,
                        'best_score' => $teamBestScore
                    ];

                    // Platzierung berechnen
                    $teamPosition = 1;
                    foreach ($sortedTeams as $teamData) {
                        if ($teamData['team_id'] == $selectedTeam->id) {
                            break;
                        }
                        $teamPosition++;
                    }
                }
            }

            $teamResults[] = [
                'discipline_name' => $discipline->name,
                'discipline_unit' => $discipline->unit ?? '',
                'higher_is_better' => $discipline->higher_is_better,
                'position' => $teamPosition,
                'scores' => $teamScores,
                'has_participated' => $hasParticipated,
                'total_participants' => $teamsInDiscipline->count(),
                'highscore' => $highscore
            ];
        }

        // Schulfarben laden - korrekter Methodenname verwenden
        $schoolColors = SchoolColorService::getColorClasses($selectedTeam->klasse->school_id ?? 0);

        // Farb-Map für JavaScript erstellen
        $colorMapForJs = SchoolColorService::getAllColorsForJs();

        return view('laufzettel', [
            'selectedTeam' => $selectedTeam,
            'teamResults' => $teamResults,
            'schoolColors' => $schoolColors,
            'teamsForJs' => $teamsForJs,
            'colorMapForJs' => $colorMapForJs,
        ]);
    }
}
