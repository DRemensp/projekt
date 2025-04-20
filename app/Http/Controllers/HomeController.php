<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Klasse;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\Comment;

class HomeController extends Controller
{
    public function index()
    {
        // Anzahl aus der Datenbank ermitteln
        $schoolCount  = School::count();
        $klasseCount  = Klasse::count();
        $teamCount    = Team::count();
        $comments = Comment::all();

        // Diese Werte an 'welcome' übergeben
        return view('welcome', compact('schoolCount', 'klasseCount', 'teamCount', 'comments'));
    }
}
