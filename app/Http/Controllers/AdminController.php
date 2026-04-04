<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Discipline;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Scoresystem;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Lade alle notwendigen Daten für die Formulare
        $schools = School::orderBy('name')->get();
        $klasses = Klasse::with('school')->orderBy('name')->get();

        // Nur Klassen für Disziplin-Form, die noch keine Disziplin haben
        $disciplineklasses = Klasse::with('school')
            ->whereDoesntHave('discipline')
            ->orderBy('name')
            ->get();

        $disciplines = Discipline::with('klasse')->orderBy('name')->get();
        $teams = Team::with('klasse')->orderBy('name')->get();

        // Lade alle Archive für die Anzeige
        $archives = Archive::orderBy('archived_date', 'desc')->get();

        // Lade das aktuelle Scoresystem
        $scoresystem = Scoresystem::where('is_active', true)->first();

        // Auto-erkannte Teamanzahl für Schulwertung (kleinste Teamanzahl)
        $teamCountsPerSchool = DB::table('schools')
            ->join('klasses', 'klasses.school_id', '=', 'schools.id')
            ->join('teams', 'teams.klasse_id', '=', 'klasses.id')
            ->select('schools.id', DB::raw('count(teams.id) as team_count'))
            ->groupBy('schools.id')
            ->pluck('team_count', 'id');
        $autoSchoolTeams = $teamCountsPerSchool->isNotEmpty() ? (int)$teamCountsPerSchool->min() : null;

        return view('admin', compact('schools', 'klasses', 'disciplines', 'teams', 'scoresystem', 'disciplineklasses', 'archives', 'autoSchoolTeams'));
    }
}
