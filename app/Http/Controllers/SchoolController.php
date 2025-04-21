<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        School::create($validated);

        return redirect()->back()->with('success', 'School created successfully.');
    }

    public function index(){
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    public function destroy(School $school){
        $school->delete();
        return redirect()->back()->with('success', 'School deleted successfully.');
    }
}
