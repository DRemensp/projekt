{{-- resources/views/admin.blade.php --}}
<x-layout>
    <x-slot:heading>
        Admin Dashboard
    </x-slot:heading>

    {{-- Haupt-Container (wie Ranking) --}}
    <div class="bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Container für den Inhalt --}}
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Allgemeine Überschrift --}}
                    <h1 class="text-3xl font-bold text-indigo-700 mb-8 text-center border-b pb-4">Verwaltung</h1>

                    {{-- Erfolgsmeldung (Gestyled) --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200 shadow-sm" role="alert">
                            <span class="font-medium">Erfolg!</span> {{ session('success') }}

                            {{-- Anzeige der generierten Anmeldedaten für Klasse --}}
                            @if(session('user_created'))
                                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded">
                                    <p class="font-medium text-blue-700">Anmeldedaten für die Klasse wurden erstellt:</p>
                                    <div class="mt-1 grid grid-cols-2 gap-2">
                                        <div>
                                            <span class="font-medium">Benutzername:</span>
                                            <span class="font-mono bg-white px-2 py-1 rounded border border-gray-200">{{ session('username') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium">Passwort:</span>
                                            <span class="font-mono bg-white px-2 py-1 rounded border border-gray-200">{{ session('password') }}</span>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-600">Bitte notieren Sie sich diese Daten, sie werden nur einmal angezeigt!</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Fehleranzeige (falls Validierungsfehler auftreten) --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-200 shadow-sm" role="alert">
                            <span class="font-medium">Fehler!</span> Bitte überprüfe die Eingaben in den Formularen.
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- Bereich für die Verwaltungselemente --}}
                    <div class="space-y-12">

                        {{-- ==================== SCHULEN VERWALTEN ==================== --}}
                        <section class="border-t border-gray-200 pt-8">
                            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Schulen verwalten</h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                {{-- Formular zum Erstellen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Neue Schule anlegen</h3>
                                    <x-school-form />
                                </div>
                                {{-- Liste vorhandener Schulen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Schulen</h3>
                                    @if($schools->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($schools as $school)
                                                <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                    <span class="text-gray-700">{{ $school->name }}</span>
                                                    {{-- Lösch-Button mit Icon --}}
                                                    <form action="{{ route('schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Schule {{ $school->name }} wirklich löschen? Alle zugehörigen Klassen, Teams und Disziplinen werden ebenfalls gelöscht!');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-150 p-1 rounded hover:bg-red-100" title="Schule löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="italic text-gray-500">Keine Schulen vorhanden.</p>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- ==================== KLASSEN VERWALTEN ==================== --}}
                        <section class="border-t border-gray-200 pt-8">
                            <h2 class="text-2xl font-semibold mb-6 text-green-700">Klassen verwalten</h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                {{-- Formular zum Erstellen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Neue Klasse anlegen</h3>
                                    @if($schools->count() > 0)
                                        <x-klasse-form :schools="$schools" />
                                    @else
                                        <p class="text-red-600 italic">Bitte zuerst eine Schule anlegen!</p>
                                    @endif
                                </div>
                                {{-- Liste vorhandener Klassen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Klassen</h3>
                                    @if($klasses->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($klasses as $klasse)
                                                <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                    <div>
                                                        <span class="text-gray-700">{{ $klasse->name }}</span>
                                                        <span class="text-xs text-gray-500 ml-2">({{ $klasse->school->name ?? 'Keine Schule' }})</span>
                                                        @if($klasse->password)
                                                            <span class="text-xs text-blue-500 ml-2">Password: {{ $klasse->password }}</span>
                                                        @endif
                                                    </div>
                                                    {{-- Lösch-Button --}}
                                                    <form action="{{ route('klasses.destroy', $klasse->id) }}" method="POST" onsubmit="return confirm('Klasse {{ $klasse->name }} wirklich löschen? Alle zugehörigen Teams und Disziplinen werden ebenfalls gelöscht!');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-150 p-1 rounded hover:bg-red-100" title="Klasse löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="italic text-gray-500">Keine Klassen vorhanden.</p>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- ==================== TEAMS VERWALTEN ==================== --}}
                        <section class="border-t border-gray-200 pt-8">
                            <h2 class="text-2xl font-semibold mb-6 text-purple-700">Teams verwalten</h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                {{-- Formular zum Erstellen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Neues Team anlegen</h3>
                                    @if($klasses->count() > 0)
                                        <x-team-form :klasses="$klasses" />
                                    @else
                                        <p class="text-red-600 italic">Bitte zuerst eine Klasse anlegen!</p>
                                    @endif
                                </div>
                                {{-- Liste vorhandener Teams --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Teams</h3>
                                    @if($teams->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($teams as $team)
                                                <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                    <div>
                                                        <span class="text-gray-700">{{ $team->name }}</span>
                                                        <span class="text-xs text-gray-500 ml-2">({{ $team->klasse->name ?? 'Keine Klasse' }})</span>
                                                    </div>
                                                    {{-- Lösch-Button --}}
                                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST" onsubmit="return confirm('Team {{ $team->name }} wirklich löschen?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-150 p-1 rounded hover:bg-red-100" title="Team löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="italic text-gray-500">Keine Teams vorhanden.</p>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- ==================== DISZIPLINEN VERWALTEN ==================== --}}
                        <section class="border-t border-gray-200 pt-8">
                            <h2 class="text-2xl font-semibold mb-6 text-orange-700">Disziplinen verwalten</h2>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                {{-- Formular zum Erstellen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Neue Disziplin anlegen</h3>
                                    @if($klasses->count() > 0)
                                        <x-discipline-form :klasses="$klasses" />
                                    @else
                                        <p class="text-red-600 italic">Bitte zuerst eine Klasse anlegen!</p>
                                    @endif
                                </div>
                                {{-- Liste vorhandener Disziplinen --}}
                                <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Disziplinen</h3>
                                    @if($disciplines->count() > 0)
                                        <ul class="space-y-2">
                                            @foreach($disciplines as $discipline)
                                                <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                    <div>
                                                        <span class="text-gray-700">{{ $discipline->name }}</span>
                                                        <span class="text-xs text-gray-500 ml-2">({{ $discipline->klasse->name ?? 'Keine Klasse' }})</span>
                                                    </div>
                                                    {{-- Lösch-Button --}}
                                                    <form action="{{ route('disciplines.destroy', $discipline->id) }}" method="POST" onsubmit="return confirm('Disziplin {{ $discipline->name }} wirklich löschen?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-150 p-1 rounded hover:bg-red-100" title="Disziplin löschen">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="italic text-gray-500">Keine Disziplinen vorhanden.</p>
                                    @endif
                                </div>
                            </div>
                        </section>

                    </div> {{-- Ende space-y-12 --}}
                </div> {{-- Ende p-6/p-8 --}}

        </div> {{-- Ende max-w-7xl --}}
    </div> {{-- Ende bg-gray-100 --}}
</x-layout>
