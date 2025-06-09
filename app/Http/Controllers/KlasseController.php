<?php

namespace App\Http\Controllers;

use App\Models\Klasse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\PasswordGenerator;


class KlasseController extends Controller
{
    protected $passwordGenerator;

    public function __construct(PasswordGenerator $passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'klasse_name'  => 'required|max:255',
            'school_id'    => 'required|integer|exists:schools,id',
        ]);

        // Generate a random password
        $password = $this->passwordGenerator->generate();

        // Create a user account for the class
        $user = User::create([
            'name'     => $validated['klasse_name'],
            'password' => Hash::make($password)
        ]);

        // Create the class with the password
        Klasse::create([
            'name'      => $validated['klasse_name'],
            'school_id' => $validated['school_id'],
            'user_id'   => $user->id,
            'password'  => $password
        ]);


        // Return with success message and the generated password
        return redirect()->back()->with([
            'success' => 'Klasse created successfully.',
            'user_created' => true,
            'username' => $validated['klasse_name'],
            'password' => $password,
        ]);
    }

    public function destroy($klasseId)
    {
        // 1. Finde das Model manuell anhand der ID
        $klasse = Klasse::find($klasseId);

        // 2. Prüfe, ob das Model überhaupt gefunden wurde
        if (!$klasse) {
            return redirect()->back()->with('error', 'Klasse nicht gefunden.');
        }

            // Find and delete the associated user if exists
            $user = User::where('name', $klasse->name)->first();
            if ($user) {
                $user->delete();
            }

            $deleted = $klasse->delete(); // Führe das Löschen aus

            // Prüfe, ob das Löschen erfolgreich war (delete() gibt true/false zurück)
            if ($deleted) {
                return redirect()->back()->with('success', 'Klasse erfolgreich gelöscht.');
            } else {
                return redirect()->back()->with('error', 'Klasse konnte nicht gelöscht werden.');
            }
    }
}
