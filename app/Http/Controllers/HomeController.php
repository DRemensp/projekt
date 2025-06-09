<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use App\Models\VisitCounter;

class HomeController extends Controller
{
    public function index()
    {
        // verhindert doppelte Requests durch redirections, entlastet server erheblich
        $acceptHeader = request()->header('accept', '');

        if (str_contains($acceptHeader, 'image/') && !str_contains($acceptHeader, 'text/html')) {
            abort(404);
        }

        // Anzahl aus der Datenbank ermitteln
        $schoolCount = School::count();
        $klasseCount = Klasse::count();
        $teamCount = Team::count();
        $comments = Comment::all();
        $visitcount = VisitCounter::first() ?? new VisitCounter();
        $visitcount->total_visits++;
        $visitcount->save();

        // Diese Werte an 'welcome' übergeben
        return view('welcome', compact(
            'schoolCount',
            'klasseCount',
            'teamCount',
            'comments',
            'visitcount'));
    }
}
