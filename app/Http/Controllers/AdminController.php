<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klasse;
use App\Models\Discipline;
use App\Models\Team;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Lade alle notwendigen Daten für die Formulare
        $schools = School::orderBy('name')->get();
        $klasses = Klasse::with('school')->orderBy('name')->get();
        $disciplines = Discipline::with('klasse')->orderBy('name')->get();
        $teams = Team::with('klasse')->orderBy('name')->get();


        return view('admin', compact('schools', 'klasses', 'disciplines', 'teams'));
    }
}
