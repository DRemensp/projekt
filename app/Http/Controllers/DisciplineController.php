<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class DisciplineController extends Controller
{
    private function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Keine Berechtigung');
        }
    }

    public function index()
    {
        $disciplines = Discipline::all();
        return view('disciplines.index', compact('disciplines'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        // Validiert Benutzereingaben
        $validated = $request->validate([
            'klasse_id' => 'required|exists:klasses,id',
            'discipline_name' => 'required|string|max:255',
            'higher_is_better' => 'required|boolean',
            'description' => 'nullable|string|max:255',
        ]);

        // Erstellt die Disziplin
        Discipline::create([
            'klasse_id' => $validated['klasse_id'],
            'name' => $validated['discipline_name'],
            'higher_is_better' => $validated['higher_is_better'],
            'description' => $validated['description'] ?? null,
        ]);

        Cache::forget('ranking_data');
        Cache::forget('laufzettel_index');
        return redirect()->back()->with('success', 'Disziplin erfolgreich angelegt!');
    }

    public function destroy(Discipline $discipline)
    {
        $this->ensureAdmin();
        $discipline->delete();
        (new RankingController())->recalculateAllScores();
        return redirect()->back()->with('success', 'Disziplin erfolgreich gelöscht.');
    }

    public function update(Request $request, Discipline $discipline)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'klasse_id' => [
                'required',
                'exists:klasses,id',
                Rule::unique('disciplines', 'klasse_id')->ignore($discipline->id),
            ],
            'discipline_name' => 'required|string|max:255',
            'higher_is_better' => 'required|boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $discipline->update([
            'klasse_id' => $validated['klasse_id'],
            'name' => $validated['discipline_name'],
            'higher_is_better' => $validated['higher_is_better'],
            'description' => $validated['description'] ?? null,
        ]);

        (new RankingController())->recalculateAllScores();
        return redirect()->back()->with('success', 'Disziplin erfolgreich aktualisiert.');
    }
}
