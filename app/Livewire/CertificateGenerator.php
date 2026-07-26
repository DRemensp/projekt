<?php

namespace App\Livewire;

use App\Models\Klasse;
use App\Models\School;
use App\Models\Team;
use Livewire\Component;

class CertificateGenerator extends Component
{
    /** Wert der "Alle …"-Option in den Dropdowns */
    public const ALL = 'all';

    // Daten für die Dropdowns
    public $schools;
    public $klasses = [];
    public $teams = [];

    // Ausgewählte IDs (oder self::ALL für den Sammeldruck)
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

        if ($value === self::ALL) {
            // "Alle Schulen": Klassen aller Schulen anbieten
            $this->klasses = Klasse::with('school')->orderBy('name')->get();
        } elseif ($value) {
            $this->klasses = Klasse::where('school_id', $value)->orderBy('name')->get();
        } else {
            $this->klasses = [];
        }
    }

    // Wenn sich die Klasse ändert
    public function updatedSelectedKlasse($value)
    {
        $this->selectedTeam = null;

        if ($value === self::ALL) {
            // "Alle Klassen": Teams aus allen Klassen des aktuellen Umfangs
            $this->teams = Team::whereIn('klasse_id', collect($this->klasses)->pluck('id'))
                ->orderBy('name')->get();
        } elseif ($value) {
            $this->teams = Team::where('klasse_id', $value)->orderBy('name')->get();
        } else {
            $this->teams = [];
        }
    }

    /** Ist gerade ein Sammeldruck ausgewählt? */
    public function getIsBulkProperty(): bool
    {
        return in_array(self::ALL, [$this->selectedSchool, $this->selectedKlasse, $this->selectedTeam], true);
    }

    /**
     * Beschriftung des Buttons – macht sichtbar, was die aktuelle
     * Auswahl tatsächlich drucken wird.
     */
    public function getBulkLabelProperty(): string
    {
        $klasseName = collect($this->klasses)->firstWhere('id', (int) $this->selectedKlasse)?->name;
        $schoolName = collect($this->schools)->firstWhere('id', (int) $this->selectedSchool)?->name;

        if ($this->selectedTeam === self::ALL) {
            return match (true) {
                (bool) $klasseName => 'Alle Teams der Klasse ' . $klasseName,
                (bool) $schoolName => 'Alle Teams der Schule ' . $schoolName,
                default            => 'Alle Teams (alle Schulen)',
            };
        }

        if ($this->selectedKlasse === self::ALL) {
            return $schoolName
                ? 'Alle Klassen der Schule ' . $schoolName
                : 'Alle Klassen (alle Schulen)';
        }

        return 'Alle Schulen';
    }

    public function render()
    {
        return view('livewire.certificate-generator');
    }
}
