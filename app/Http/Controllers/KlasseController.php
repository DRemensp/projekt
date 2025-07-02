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

        // passwort generieren mit Service
        $password = $this->passwordGenerator->generate();

        //User mit klasse erstellen
        $user = User::create([
            'name'     => $validated['klasse_name'],
            'password' => Hash::make($password)
        ]);

        // klasse mit passwort erstellen (in datenbank unverschlüsselt)
        Klasse::create([
            'name'      => $validated['klasse_name'],
            'school_id' => $validated['school_id'],
            'user_id'   => $user->id,
            'password'  => $password
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
        //Klasse suchen
        $klasse = Klasse::find($klasseId);

        // Prüfe, ob das Model überhaupt gefunden wurde
        if (!$klasse) {
            return redirect()->back()->with('error', 'Klasse nicht gefunden.');
        }

            //user account mit löschen
            $user = User::where('name', $klasse->name)->first();
            if ($user) {
                $user->delete();
            }

            $deleted = $klasse->delete();

            // fehlermeldung oder richtige
            if ($deleted) {
                return redirect()->back()->with('success', 'Klasse erfolgreich gelöscht.');
            } else {
                return redirect()->back()->with('error', 'Klasse konnte nicht gelöscht werden.');
            }
    }
}
