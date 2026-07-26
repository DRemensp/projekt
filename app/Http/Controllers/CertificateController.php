<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /** Wert der "Alle …"-Option in den Dropdowns */
    private const ALL = 'all';

    public function generate(Request $request)
    {
        $schoolId = $request->input('school_id');
        $klasseId = $request->input('klasse_id');
        $teamId = $request->input('team_id');

        // Sammeldruck: das tiefste Dropdown mit "Alle" bestimmt die Ebene,
        // die Auswahl darüber grenzt ein.
        if (in_array(self::ALL, [$schoolId, $klasseId, $teamId], true)) {
            return $this->generateBulk($request, $schoolId, $klasseId, $teamId);
        }

        // FALL 1: TEAM URKUNDE
        if ($teamId) {
            $team = Team::with(['klasse.school', 'disciplines'])->findOrFail($teamId);
            $data = $this->teamData($team, $this->scoresOf(Team::class));
            $filename = 'Urkunde_' . Str::slug($team->name) . '.pdf';
        }

        // FALL 2: KLASSEN URKUNDE
        elseif ($klasseId) {
            $klasse = Klasse::with('school')->findOrFail($klasseId);
            $data = $this->klasseData($klasse, $this->scoresOf(Klasse::class));
            $filename = 'Urkunde_' . Str::slug($klasse->name) . '.pdf';
        }

        // FALL 3: SCHUL URKUNDE
        elseif ($schoolId) {
            $school = School::findOrFail($schoolId);
            $data = $this->schoolData($school, $this->scoresOf(School::class));
            $filename = 'Urkunde_' . Str::slug($school->name) . '.pdf';
        } else {
            return back()->with('error', 'Bitte wählen Sie eine Ebene aus.');
        }

        $data['logoKeys'] = $this->logoKeys($request);

        $pdf = Pdf::loadView('pdf.certificate', $data)->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /**
     * Erzeugt ein einziges PDF mit einer Urkunde pro Seite.
     * "Alle Teams" schlägt "Alle Klassen" schlägt "Alle Schulen" – die
     * konkret gewählten Ebenen darüber wirken als Filter.
     */
    private function generateBulk(Request $request, ?string $schoolId, ?string $klasseId, ?string $teamId)
    {
        // Nur konkrete IDs taugen als Filter, "all" ist keine
        $schoolFilter = $schoolId === self::ALL ? null : $schoolId;
        $klasseFilter = $klasseId === self::ALL ? null : $klasseId;

        [$certificates, $filename] = match (true) {
            $teamId === self::ALL   => $this->bulkTeams($schoolFilter, $klasseFilter),
            $klasseId === self::ALL => $this->bulkKlassen($schoolFilter),
            default                 => $this->bulkSchools(),
        };

        if ($certificates->isEmpty()) {
            return back()->with('error', 'Für diese Auswahl gibt es keine Urkunden zum Drucken.');
        }

        // Viele Seiten mit Hintergrundbild brauchen spürbar Zeit und Speicher
        set_time_limit(300);

        $pdf = Pdf::loadView('pdf.certificates-bulk', [
            'certificates' => $certificates->values()->all(),
            'logoKeys'     => $this->logoKeys($request),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    /**
     * @return array{0: Collection, 1: string}
     */
    private function bulkTeams(?string $schoolId, ?string $klasseId): array
    {
        $query = Team::with(['klasse.school', 'disciplines']);
        $label = 'Alle';

        if ($klasseId) {
            $klasse = Klasse::findOrFail($klasseId);
            $query->where('klasse_id', $klasse->id);
            $label = $klasse->name;
        } elseif ($schoolId) {
            $school = School::findOrFail($schoolId);
            $query->whereIn('klasse_id', Klasse::where('school_id', $school->id)->pluck('id'));
            $label = $school->name;
        }

        $allScores = $this->scoresOf(Team::class);

        $certificates = $query->orderByDesc('score')->orderBy('name')->get()
            ->map(fn(Team $team) => $this->teamData($team, $allScores));

        return [$certificates, 'Urkunden_Teams_' . Str::slug($label) . '.pdf'];
    }

    /**
     * @return array{0: Collection, 1: string}
     */
    private function bulkKlassen(?string $schoolId): array
    {
        $query = Klasse::with('school');
        $label = 'Alle';

        if ($schoolId) {
            $school = School::findOrFail($schoolId);
            $query->where('school_id', $school->id);
            $label = $school->name;
        }

        $allScores = $this->scoresOf(Klasse::class);

        $certificates = $query->orderByDesc('score')->orderBy('name')->get()
            ->map(fn(Klasse $klasse) => $this->klasseData($klasse, $allScores));

        return [$certificates, 'Urkunden_Klassen_' . Str::slug($label) . '.pdf'];
    }

    /**
     * @return array{0: Collection, 1: string}
     */
    private function bulkSchools(): array
    {
        $allScores = $this->scoresOf(School::class);

        $certificates = School::orderByDesc('score')->orderBy('name')->get()
            ->map(fn(School $school) => $this->schoolData($school, $allScores));

        return [$certificates, 'Urkunden_Schulen.pdf'];
    }

    // -------------------------------------------------------------------------

    private function teamData(Team $team, Collection $allScores): array
    {
        return [
            'type' => 'TEAM',
            'name' => $team->name,
            'subtext' => $team->klasse->name . ' - ' . $team->klasse->school->name,
            'rank' => $this->rankOf($team->score, $allScores),
            'score' => $team->score,
            'discipline' => $team->disciplines->first()->name ?? 'Allgemein',
            'date' => now()->format('d.m.Y'),
        ];
    }

    private function klasseData(Klasse $klasse, Collection $allScores): array
    {
        return [
            'type' => 'KLASSE',
            'name' => $klasse->name,
            'subtext' => $klasse->school->name,
            'rank' => $this->rankOf($klasse->score, $allScores),
            'score' => $klasse->score,
            'discipline' => 'Klassenwertung',
            'date' => now()->format('d.m.Y'),
        ];
    }

    private function schoolData(School $school, Collection $allScores): array
    {
        return [
            'type' => 'SCHULE',
            'name' => $school->name,
            'subtext' => 'Gesamtwertung',
            'rank' => $this->rankOf($school->score, $allScores),
            'score' => $school->score,
            'discipline' => 'Schulwertung',
            'date' => now()->format('d.m.Y'),
        ];
    }

    /**
     * Alle Scores einer Ebene einmalig laden, damit der Rang ohne
     * zusätzliche Query pro Urkunde bestimmt werden kann.
     */
    private function scoresOf(string $model): Collection
    {
        return $model::query()->pluck('score');
    }

    private function rankOf(int $score, Collection $allScores): int
    {
        return $allScores->filter(fn($other) => $other > $score)->count() + 1;
    }

    private function logoKeys(Request $request): array
    {
        $allLogoKeys = ['steinbeis', 'heuss', 'stradin', 'kerschensteiner'];

        return $request->has('logos_submitted')
            ? $request->input('logos', [])
            : $allLogoKeys;
    }
}
