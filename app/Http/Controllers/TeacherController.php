<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teams = Team::with('klasse')->orderBy('name')->get();
        $disciplines = Discipline::orderBy('name')->get();

        $allScoresRaw = DB::table('discipline_team')
            ->select('discipline_id', 'team_id', 'score_1', 'score_2')
            ->get();

        $allScores = [];
        foreach ($allScoresRaw as $score) {
            $key = $score->discipline_id . '_' . $score->team_id;
            $allScores[$key] = [
                'score_1' => $score->score_1 !== null ? (float)$score->score_1 : null,
                'score_2' => $score->score_2 !== null ? (float)$score->score_2 : null,
            ];
        }

        return view('teacher', compact(
            'teams',
            'disciplines',
            'allScores'
        ));
    }
}
