<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scoresystem;
use Illuminate\Http\Request;

class ScoresystemController extends Controller
{
    public function store(Request $request)
    {
        // Validierung hinzufügen
        $validated = $request->validate([
            'first_place' => 'required|integer|min:0',
            'second_place' => 'required|integer|min:0',
            'third_place' => 'required|integer|min:0',
            'max_score' => 'required|integer|min:0',
            'score_step' => 'required|integer|min:1',
        ]);

        // Korrekte updateOrCreate Syntax
        $scoresystem = Scoresystem::updateOrCreate(
            ['is_active' => true], // Suchkriterien
            $validated // Daten zum Aktualisieren/Erstellen
        );

        return redirect()->back()->with('success', 'Scoresystem erfolgreich aktualisiert.');
    }
}
