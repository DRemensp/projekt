<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use App\Models\User;
use App\Services\PasswordGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KlasseController extends Controller
{
    protected PasswordGenerator $passwordGenerator;

    public function __construct(PasswordGenerator $passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
    }

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
            'klasse_name' => 'required|max:255',
            'school_id' => 'required|integer|exists:schools,id',
        ]);

        // Passwort generieren mit Service
        $password = $this->passwordGenerator->generate();

        // User mit Klasse erstellen
        $user = User::create([
            'name' => $validated['klasse_name'],
            'password' => Hash::make($password),
        ]);

        // Klasse mit Passwort erstellen (in Datenbank unverschlüsselt)
        Klasse::create([
            'name' => $validated['klasse_name'],
            'school_id' => $validated['school_id'],
            'user_id' => $user->id,
            'password' => $password,
        ]);

        return redirect()->back()->with([
            'success' => 'Klasse created successfully.',
            'user_created' => true,
            'username' => $validated['klasse_name'],
            'password' => $password,
        ]);
    }

    public function destroy($klasseId)
    {
        $this->ensureAdmin();

        // Klasse suchen
        $klasse = Klasse::find($klasseId);

        if (!$klasse) {
            return redirect()->back()->with('error', 'Klasse nicht gefunden.');
        }

        // User-Account mit löschen
        $user = User::where('name', $klasse->name)->first();
        if ($user) {
            $user->delete();
        }

        $deleted = $klasse->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Klasse erfolgreich gelöscht.');
        }

        return redirect()->back()->with('error', 'Klasse konnte nicht gelöscht werden.');
    }

    public function update(Request $request, Klasse $klasse)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'klasse_name' => 'required|max:255',
            'school_id' => 'required|integer|exists:schools,id',
        ]);

        $oldName = $klasse->name;

        $klasse->update([
            'name' => $validated['klasse_name'],
            'school_id' => $validated['school_id'],
        ]);

        $user = null;
        if (!empty($klasse->user_id)) {
            $user = User::find($klasse->user_id);
        }
        if (!$user) {
            $user = User::where('name', $oldName)->first();
        }
        if ($user) {
            $user->name = $validated['klasse_name'];
            $user->save();
        }

        return redirect()->back()->with('success', 'Klasse erfolgreich aktualisiert.');
    }
}
