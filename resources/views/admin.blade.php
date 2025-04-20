<!-- resources/views/admin.blade.php -->
<x-layout>
    <x-slot:heading>
        Admin Dashboard
    </x-slot:heading>

    {{-- Erfolgsmeldung --}}
    @if(session('success'))
        <div class="p-4 mb-4 text-green-800 rounded-md bg-green-100">
            {{ session('success') }}
        </div>
    @endif

    <!-- SCHULE -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <!-- Linke Spalte: Formular für neue Schule -->
        <div>
            <x-school-form />
        </div>
        <!-- Rechte Spalte: Liste bereits erstellter Schulen -->
        <div>
            <h2 class="font-semibold mb-2">Bereits erstellte Schulen:</h2>
            <ul class="list-disc ml-6">
                @forelse($schools as $school)
                    <li class="flex items-center gap-2">
                        <!-- Schulname -->
                        <span>{{ $school->name }}</span>

                        <!-- Lösch-Button (klein und grau) -->
                        <form
                            action="{{ route('schools.destroy', $school->id) }}"
                            method="POST"
                            onsubmit="return confirm('Möchtest du diese Schule wirklich löschen?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-2 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300"
                            >
                                Löschen
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="italic">Keine Schulen vorhanden.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- KLASSE -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <!-- Linke Spalte: Formular für neue Klasse -->
        <div>
            <x-klasse-form :schools="$schools" />
        </div>
        <!-- Rechte Spalte: Liste vorhandener Klassen -->
        <div>
            <h2 class="font-semibold mb-2">Bereits erstellte Klassen:</h2>
            <ul class="list-disc ml-6">
                @forelse($klasses as $klasse)
                    <li class="flex items-center gap-2">
                        <!-- Klassenname -->
                        <span>{{ $klasse->name }}</span>

                        <!-- Lösch-Button (klein und grau) -->
                        <form
                            action="{{ route('klasses.destroy', $klasse->id) }}"
                            method="POST"
                            onsubmit="return confirm('Möchtest du diese Klasse wirklich löschen?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-2 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300"
                            >
                                Löschen
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="italic">Keine Klassen vorhanden.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- TEAM -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <!-- Linke Spalte: Formular für neues Team -->
        <div>
            <x-team-form :klasses="$klasses" />
        </div>
        <!-- Rechte Spalte: Liste vorhandener Teams -->
        <div>
            <h2 class="font-semibold mb-2">Bereits erstellte Teams:</h2>
            <ul class="list-disc ml-6">
                @forelse($teams as $team)
                    <li class="flex items-center gap-2">
                        <!-- Teamname -->
                        <span>{{ $team->name }}</span>

                        <!-- Lösch-Button (klein und grau) -->
                        <form
                            action="{{ route('teams.destroy', $team->id) }}"
                            method="POST"
                            onsubmit="return confirm('Möchtest du dieses Team wirklich löschen?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-2 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300"
                            >
                                Löschen
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="italic">Keine Teams vorhanden.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- DISZIPLIN -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <!-- Linke Spalte: Formular für neue Disziplin -->
        <div>
            <x-discipline-form :klasses="$klasses" />
        </div>
        <!-- Rechte Spalte: Liste vorhandener Disziplinen -->
        <div>
            <h2 class="font-semibold mb-2">Bereits erstellte Disziplinen:</h2>
            <ul class="list-disc ml-6">
                @forelse($disciplines as $discipline)
                    <li class="flex items-center gap-2">
                        <!-- Disziplinname -->
                        <span>{{ $discipline->name }}</span>

                        <!-- Lösch-Button (klein und grau) -->
                        <form
                            action="{{ route('disciplines.destroy', $discipline->id) }}"
                            method="POST"
                            onsubmit="return confirm('Möchtest du diese Disziplin wirklich löschen?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="px-2 py-1 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300"
                            >
                                Löschen
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="italic">Keine Disziplinen vorhanden.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- TEAM-DISZIPLIN-VERKNÜPFUNG -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <!-- Linke Spalte: Formular für Team-Disziplin-Verknüpfung -->
        <div>
            <x-teamtable-form
                :teams="$teams"
                :disciplines="$disciplines"
            />
        </div>
    </div>
</x-layout>
