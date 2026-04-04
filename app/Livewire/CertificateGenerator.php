<?php

namespace App\Livewire;

use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use Livewire\Component;

class CertificateGenerator extends Component
{
    // Daten für die Dropdowns
    public $schools;
    public $klasses = [];
    public $teams = [];

    // Ausgewählte IDs
    public $selectedSchool = null;
    public $selectedKlasse = null;
    public $selectedTeam = null;

    public function mount()
    {
        // Beim Start nur Schulen laden
        $this->schools = School::orderBy('name')->get();
    }

    // Wenn sich die Schule ändert
    public function updatedSelectedSchool($value)
    {
        $this->selectedKlasse = null;
        $this->selectedTeam = null;
        $this->teams = [];

        if ($value) {
            $this->klasses = Klasse::where('school_id', $value)->orderBy('name')->get();
        } else {
            $this->klasses = [];
        }
    }

    // Wenn sich die Klasse ändert
    public function updatedSelectedKlasse($value)
    {
        $this->selectedTeam = null;

        if ($value) {
            $this->teams = Team::where('klasse_id', $value)->orderBy('name')->get();
        } else {
            $this->teams = [];
        }
    }

    public function render()
    {
        return view('livewire.certificate-generator');
    }
}
