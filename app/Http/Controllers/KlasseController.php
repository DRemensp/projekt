<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use Illuminate\Http\Request;

class KlasseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'klasse_name'  => 'required|max:255',
            'school_id'    => 'required|integer|exists:schools,id',
        ]);
        Klasse::create([
            'name'      => $validated['klasse_name'],
            'school_id' => $validated['school_id'],
        ]);

        return redirect()->back()->with('success', 'Klasse created successfully.');
    }

    public function destroy(Klasse $klasse){
        $klasse->delete();
        return redirect()->back()->with('success', 'Klasse deleted successfully.');
    }
}
