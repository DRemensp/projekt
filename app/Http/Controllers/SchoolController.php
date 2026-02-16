<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    private function ensureAdmin(): void
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Keine Berechtigung');
        }
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        School::create($validated);

        return redirect()->back()->with('success', 'School created successfully.');
    }

    public function index()
    {
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    public function destroy(School $school)
    {
        $this->ensureAdmin();

        // Sammle alle Klassennamen dieser Schule, um die zugehörigen User zu finden
        $klasseNames = $school->klasses()->pluck('name')->toArray();

        // Lösche alle User-Accounts, die zu diesen Klassen gehören
        if (!empty($klasseNames)) {
            User::whereIn('name', $klasseNames)->delete();
        }

        // Lösche die Schule (Cascade löscht automatisch Klassen, Teams, etc.)
        $school->delete();

        return redirect()->back()->with('success', 'Schule und alle zugehörigen Daten erfolgreich gelöscht.');
    }

    public function update(Request $request, School $school)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $school->update($validated);

        return redirect()->back()->with('success', 'Schule erfolgreich aktualisiert.');
    }
}
