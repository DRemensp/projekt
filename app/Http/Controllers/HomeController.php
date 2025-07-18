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

        // Schüler zählen durch Summierung aller Team-Mitglieder
        // Wenn ein Team keine Mitglieder hat, rechnen wir +3
        $studentCount = Team::all()->sum(function ($team) {
            if (is_array($team->members) && count($team->members) > 0) {
                return count($team->members);
            } else {
                // Team hat keine Mitglieder eingetragen -> +3
                return 3;
            }
        });

        $comments = Comment::all();
        $visitcount = VisitCounter::first() ?? new VisitCounter();
        $visitcount->total_visits++;
        $visitcount->save();

        // Diese Werte an 'welcome' übergeben
        return view('welcome', compact(
            'schoolCount',
            'klasseCount',
            'teamCount',
            'studentCount',
            'comments',
            'visitcount'));
    }
}
