<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function generate(Request $request)
    {
        $schoolId = $request->input('school_id');
        $klasseId = $request->input('klasse_id');
        $teamId = $request->input('team_id');

        $data = [];
        $filename = 'urkunde.pdf';

        // FALL 1: TEAM URKUNDE
        if ($teamId) {
            // Team laden
            $team = Team::with(['klasse.school', 'disciplines'])->findOrFail($teamId);

            // LOGIK VEREINFACHT:
            // Wir zählen einfach, wie viele Teams MEHR Punkte haben als das aktuelle Team.
            // Das entspricht genau der Logik: "Sortieren und schauen, an welchem Index man steht".
            $rank = Team::where('score', '>', $team->score)->count() + 1;

            $data = [
                'type' => 'TEAM',
                'name' => $team->name,
                'subtext' => $team->klasse->name . ' - ' . $team->klasse->school->name,
                'rank' => $rank,
                'score' => $team->score,
                'discipline' => $team->disciplines->first()->name ?? 'Allgemein',
                'date' => now()->format('d.m.Y'),
            ];

            $filename = 'Urkunde_' . Str::slug($team->name) . '.pdf';
        }

        // FALL 2: KLASSEN URKUNDE
        elseif ($klasseId) {
            $klasse = Klasse::with('school')->findOrFail($klasseId);

            // Wie viele Klassen haben mehr Punkte?
            $rank = Klasse::where('score', '>', $klasse->score)->count() + 1;

            $data = [
                'type' => 'KLASSE',
                'name' => $klasse->name,
                'subtext' => $klasse->school->name,
                'rank' => $rank,
                'score' => $klasse->score,
                'discipline' => 'Klassenwertung',
                'date' => now()->format('d.m.Y'),
            ];

            $filename = 'Urkunde_' . Str::slug($klasse->name) . '.pdf';
        }

        // FALL 3: SCHUL URKUNDE
        elseif ($schoolId) {
            $school = School::findOrFail($schoolId);

            // Wie viele Schulen haben mehr Punkte?
            $rank = School::where('score', '>', $school->score)->count() + 1;

            $data = [
                'type' => 'SCHULE',
                'name' => $school->name,
                'subtext' => 'Gesamtwertung',
                'rank' => $rank,
                'score' => $school->score,
                'discipline' => 'Schulwertung',
                'date' => now()->format('d.m.Y'),
            ];

            $filename = 'Urkunde_' . Str::slug($school->name) . '.pdf';
        } else {
            return back()->with('error', 'Bitte wählen Sie eine Ebene aus.');
        }

        // PDF Generieren
        $pdf = Pdf::loadView('pdf.certificate', $data)->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
}
