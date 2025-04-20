<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klasse;
use App\Models\Discipline;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Comment;

class AdminController extends Controller
{
    public function index()
    {
        // Alles, was Du im Dashboard brauchst
        $schools = School::all();
        $klasses = Klasse::all();
        $disciplines = Discipline::all();
        $teams = Team::all();

        return view('admin', compact('schools', 'klasses', 'disciplines', 'teams'));
    }
}
