<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function destroy($klasseId)
    {
        // 1. Finde das Model manuell anhand der ID
        $klasse = Klasse::find($klasseId);

        // 2. Prüfe, ob das Model überhaupt gefunden wurde
        if (!$klasse) {
            // Optional: Logge den Fehler
            // Log::warning("Versuch, nicht existierende Klasse ID " . $klasseId . " zu löschen.");
            return redirect()->back()->with('error', 'Klasse nicht gefunden.');
        }

        // 3. Versuche das gefundene Model zu löschen (mit Fehlerbehandlung)
        try {
            $deleted = $klasse->delete(); // Führe das Löschen aus

            // Prüfe, ob das Löschen erfolgreich war (delete() gibt true/false zurück)
            if ($deleted) {
                return redirect()->back()->with('success', 'Klasse erfolgreich gelöscht.');
            } else {
                // Sollte selten passieren, z.B. wenn ein 'deleting' Event false zurückgibt
                Log::error("Klasse ID " . $klasseId . " konnte nicht gelöscht werden (delete() gab false zurück).");
                return redirect()->back()->with('error', 'Klasse konnte nicht gelöscht werden.');
            }
        } catch (\Exception $e) {
            // Fange alle anderen Fehler ab (z.B. Datenbankprobleme)
            // Logge den spezifischen Fehler für die Fehlersuche
            Log::error("Fehler beim Löschen von Klasse ID " . $klasseId . ": " . $e->getMessage());
            // Gib dem Benutzer eine allgemeine Fehlermeldung
            return redirect()->back()->with('error', 'Ein Datenbankfehler ist beim Löschen der Klasse aufgetreten.');
        }
    }
}
