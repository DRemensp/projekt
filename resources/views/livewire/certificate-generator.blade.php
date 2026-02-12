<div class="bg-gray-50 night-panel dark:bg-gray-800 p-6 rounded-lg shadow dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 transition-colors duration-300">
    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200 transition-colors duration-300">
        Urkunde erstellen
    </h3>

    {{-- Wir nutzen ein GET Formular, damit die IDs in der URL landen --}}
    <form action="{{ route('certificate.generate') }}" method="GET" target="_blank">
        <div class="space-y-4">

            {{-- 1. Schule Dropdown --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Schule</label>
                <select wire:model.live="selectedSchool" name="school_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Schule wählen --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 2. Klasse Dropdown (Nur sichtbar wenn Schule gewählt) --}}
            <div class="{{ empty($klasses) ? 'opacity-50 pointer-events-none' : '' }} transition-opacity duration-300">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Klasse (Optional)</label>
                <select wire:model.live="selectedKlasse" name="klasse_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Gesamte Schule --</option>
                    @foreach($klasses as $schoolKlasse)
                        <option value="{{ $schoolKlasse->id }}">{{ $schoolKlasse->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Team Dropdown (Nur sichtbar wenn Klasse gewählt) --}}
            <div class="{{ empty($teams) ? 'opacity-50 pointer-events-none' : '' }} transition-opacity duration-300">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Team (Optional)</label>
                <select wire:model.live="selectedTeam" name="team_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Gesamte Klasse --</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Action Button --}}
            <div class="pt-4">
                <button type="submit"
                        @if(!$selectedSchool) disabled @endif
                        class="w-full py-2 px-4 rounded-lg font-medium shadow-md transition-all duration-200
                        {{ $selectedSchool
                            ? 'bg-gradient-to-r from-teal-500 to-emerald-500 text-white hover:from-teal-600 hover:to-emerald-600 hover:scale-105'
                            : 'bg-gray-300 dark:bg-gray-700 text-gray-500 cursor-not-allowed'
                        }}">
                    @if($selectedTeam)
                        📄 Urkunde für Team drucken
                    @elseif($selectedKlasse)
                        📄 Urkunde für Klasse drucken
                    @elseif($selectedSchool)
                        📄 Urkunde für Schule drucken
                    @else
                        Bitte Schule wählen
                    @endif
                </button>
            </div>
        </div>
    </form>
</div>
