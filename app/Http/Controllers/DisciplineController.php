<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index()
    {
        $disciplines = Discipline::all();
        return view('disciplines.index', compact('disciplines'));
    }

    public function store(Request $request)
    {
        // Korrigiere hier die Keys
        $validated = $request->validate([
            'klasse_id'         => 'required|exists:klasses,id',
            'discipline_name'   => 'required|string|max:255',
            'max_score'         => 'required|integer',
            'score_step'        => 'required|integer',
            'higher_is_better'  => 'required|boolean',
            'description'       => 'nullable|string'
        ]);

        // Speichere die Klassen-ID in "klasse_id" und den Namen in "name"
        Discipline::create([
            'klasse_id'  => $validated['klasse_id'],
            'name'       => $validated['discipline_name'],          // nicht 'discipline_name'
            'max_score'  => $validated['max_score'],
            'score_step' => $validated['score_step'],
            'higher_is_better' => $validated['higher_is_better'],
            'description'=> $validated['description'] ?? null
        ]);

        return redirect()->back()->with('success', 'Disziplin erfolgreich angelegt!');
    }

    public function destroy(Discipline $discipline){
        $discipline->delete();
        return redirect()->back()->with('success', 'School deleted successfully.');
    }
}
