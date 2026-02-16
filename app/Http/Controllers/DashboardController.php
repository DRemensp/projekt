<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Team;
use App\Models\Klasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Aktuell eingeloggten User holen
        $user = Auth::user();

        // Klasse über den Namen finden (da User.name = Klasse.name)
        $klasse = Klasse::where('name', $user->name)->with(['discipline', 'school'])->first();

        if (!$klasse) {
            return redirect()->route('login')->with('error', 'Keine zugehörige Klasse gefunden.');
        }

        // Disziplin der Klasse holen
        $discipline = $klasse->discipline;

        if (!$discipline) {
            return view('dashboard', [
                'klasse' => $klasse,
                'discipline' => null,
                'teams' => collect(),
                'allScores' => []
            ]);
        }

        // Alle Teams holen (für Score-Eingabe in DIESER Disziplin)
        $teams = Team::with('klasse')->orderBy('name')->get();

        // Alle aktuellen Scores für DIESE Disziplin holen
        $allScoresRaw = DB::table('discipline_team')
            ->where('discipline_id', $discipline->id)
            ->select('team_id', 'score_1', 'score_2')
            ->get();

        $allScores = [];
        foreach ($allScoresRaw as $score) {
            $key = $discipline->id . '_' . $score->team_id;
            $allScores[$key] = [
                'score_1' => $score->score_1 !== null ? (float)$score->score_1 : null,
                'score_2' => $score->score_2 !== null ? (float)$score->score_2 : null,
            ];
        }

        $scanTeamId = $request->integer('scan_team');
        $openScoreModal = $request->boolean('open_score_modal');

        if (!$scanTeamId || !$teams->pluck('id')->contains($scanTeamId)) {
            $scanTeamId = null;
            $openScoreModal = false;
        }

        return view('dashboard', compact(
            'klasse',
            'discipline',
            'teams',
            'allScores',
            'scanTeamId',
            'openScoreModal'
        ));
    }
}
