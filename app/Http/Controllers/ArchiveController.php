<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Services\SchoolColorService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArchiveController extends Controller
{
    public function index()
    {
        $archives = Archive::orderBy('archived_date', 'desc')->get();
        return view('archive.index', compact('archives'));
    }

    public function show(Archive $archive)
    {
        return view('archive.show', compact('archive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Alle aktuellen Daten sammeln
        $archiveData = $this->collectCurrentData();

        Archive::create([
            'name' => $request->name,
            'description' => $request->description,
            'archived_date' => Carbon::now(),
            'data' => $archiveData
        ]);

        return redirect()->back()->with('success', 'Archiv wurde erfolgreich erstellt!');
    }

    public function destroy(Archive $archive)
    {
        $archive->delete();

        return redirect()->back()->with('success', 'Archiv wurde erfolgreich gelöscht!');
    }

    private function collectCurrentData()
    {
        // Schulen mit allen Daten
        $schools = School::with([
            'klasses.teams.disciplines' => function($query) {
                $query->withPivot(['score_1', 'score_2']);
            }
        ])->orderBy('score', 'desc')->get();

        // Color mapping für Schulnamen erstellen
        $schoolColorsByName = [];
        foreach ($schools as $school) {
            $schoolColorsByName[$school->name] = SchoolColorService::getColorClasses($school->id);
        }

        // Rankings berechnen
        $schoolRanking = School::orderBy('score', 'desc')->get()->map(function($school, $index) {
            return [
                'rank' => $index + 1,
                'name' => $school->name,
                'score' => $school->score
            ];
        });

        $klasseRanking = Klasse::with('school')->orderBy('score', 'desc')->get()->map(function($klasse, $index) {
            return [
                'rank' => $index + 1,
                'name' => $klasse->name,
                'school_name' => $klasse->school->name,
                'score' => $klasse->score
            ];
        });

        $teamRanking = Team::with('klasse.school')->orderBy('score', 'desc')->get()->map(function($team, $index) {
            return [
                'rank' => $index + 1,
                'name' => $team->name,
                'klasse_name' => $team->klasse->name,
                'school_name' => $team->klasse->school->name,
                'score' => $team->score,
                'bonus' => $team->bonus,
                'members' => $team->members
            ];
        });

        // Beste Teams pro Disziplin
        $disciplines = Discipline::with(['teams' => function($query) {
            $query->with('klasse.school');
        }])->get();

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
                    'discipline_name' => $discipline->name,
                    'discipline_description' => $discipline->description,
                    'team_name' => $bestTeam->name,
                    'klasse_name' => $bestTeam->klasse->name,
                    'school_name' => $bestTeam->klasse->school->name,
                    'best_score' => $bestScore,
                    'higher_is_better' => $discipline->higher_is_better
                ];
            }
        }

        return [
            'created_at' => Carbon::now()->toDateTimeString(),
            'total_schools' => School::count(),
            'total_klasses' => Klasse::count(),
            'total_teams' => Team::count(),
            'total_students' => Team::all()->sum(function ($team) {
                return is_array($team->members) && count($team->members) > 0 ? count($team->members) : 3;
            }),
            'school_ranking' => $schoolRanking,
            'klasse_ranking' => $klasseRanking,
            'team_ranking' => $teamRanking,
            'best_teams_per_discipline' => $bestTeamsPerDiscipline,
            'schools_detailed' => $schools,
            'school_colors_by_name' => $schoolColorsByName // Farbmapping nach Namen
        ];
    }

    private function getTeamBestScore($score1, $score2, $higherIsBetter)
    {
        if ($score1 === null && $score2 === null) return null;
        if ($score1 === null) return $score2;
        if ($score2 === null) return $score1;
        return $higherIsBetter ? max($score1, $score2) : min($score1, $score2);
    }

    private function isScoreBetter($newScore, $currentBestScore, $higherIsBetter)
    {
        if ($newScore === null) return false;
        if ($currentBestScore === null) return true;
        return $higherIsBetter ? ($newScore > $currentBestScore) : ($newScore < $currentBestScore);
    }
}
