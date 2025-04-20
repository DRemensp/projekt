<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function showTeacherDashboard()
    {
        // Beispielhafte Abfrage aus der Datenbank:

        $disciplines = Discipline::all();

        // Oder falls du ein Eloquent Model verwendest:
        // $disciplines = Discipline::all();

        // Anschließend mit der View teilen:
        return view('teacher', compact('disciplines'));
    }
}
