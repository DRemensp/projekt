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
        //validiert benutzer eingaben
        $validated = $request->validate([
            'klasse_id'         => 'required|exists:klasses,id',
            'discipline_name'   => 'required|string|max:255',
            'higher_is_better'  => 'required|boolean',
            'description' => 'nullable|string|max:255'
        ]);

        // erstellt die Disziplin
        Discipline::create([
            'klasse_id'  => $validated['klasse_id'],
            'name'       => $validated['discipline_name'],
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
