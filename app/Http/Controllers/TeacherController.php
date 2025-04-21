<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klasse;
use App\Models\Discipline;
use App\Models\Team;
use Illuminate\Http\Request;
// use App\Models\Comment; // Auskommentiert, falls nicht benötigt

class TeacherController extends Controller
{
    public function index()
    {
        // Lade alle notwendigen Daten für die Formulare und Listen
        // Optional: Sortiere die Listen für eine bessere Übersicht
        $schools = School::orderBy('name')->get();
        $klasses = Klasse::with('school')->orderBy('name')->get(); // Lade Schule für Anzeige
        $disciplines = Discipline::with('klasse')->orderBy('name')->get(); // Lade Klasse für Anzeige
        $teams = Team::with('klasse')->orderBy('name')->get(); // Lade Klasse für Anzeige

        // Gebe die Daten an die neue Admin-View zurück
        return view('admin', compact('schools', 'klasses', 'disciplines', 'teams'));
    }
}
