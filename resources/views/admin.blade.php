<x-layout>
    <x-slot:heading>
        Admin Dashboard
    </x-slot:heading>

    {{-- Haupt-Container (wie Ranking) --}}
    <div class="bg-gradient-to-br from-blue-100 to-green-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 md:p-8 text-gray-900">

                @if(session('success'))
                    <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200 shadow-sm" role="alert">
                        <span class="font-medium">Erfolg!</span> {{ session('success') }}

                        {{-- infos für den erstellen Nutzer einer Klasse --}}
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

                {{-- bei Validierungs fehler allgemeine meldung--}}
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

                {{-- Navigation Arrows --}}
                <button
                    id="prevBtn"
                    class="absolute left-[5px] top-1/2 transform -translate-y-1/2 z-10 bg-gradient-to-r from-blue-300 to-blue-500 border-2 border-gray-500 rounded-xl w-12 h-12 flex items-center justify-center cursor-pointer transition-all duration-200 text-white hover:from-blue-600 hover:to-blue-700 hover:border-blue-700 hover:shadow-lg hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:from-gray-400 disabled:to-gray-500 disabled:border-gray-500 shadow-md"
                    aria-label="Vorheriger Bereich"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button
                    id="nextBtn"
                    class="absolute right-[5px] top-1/2 transform -translate-y-1/2 z-10 bg-gradient-to-r from-blue-300 to-blue-500 border-2 border-gray-500 rounded-xl w-12 h-12 flex items-center justify-center cursor-pointer transition-all duration-200 text-white hover:from-blue-600 hover:to-blue-700 hover:border-blue-700 hover:shadow-lg hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:from-gray-400 disabled:to-gray-500 disabled:border-gray-500 shadow-md"
                    aria-label="Nächster Bereich"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                {{-- Carousel Content --}}
                <div class="overflow-hidden">
                    <div
                        class="flex transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] w-[600%]"
                        id="carouselSlides"
                        style="transform: translateX(0%)"
                    >

                        {{-- SLIDE 1: Punktesystem --}}
                        <div class="w-[16.666%] flex-shrink-0 opacity-100 transition-opacity duration-300 carousel-slide active">
                            <div class="px-4 sm:px-2 sm:py-6 min-h-[500px] sm:min-h-[300px]">
                                <h2 class="text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 border-b-2 border-amber-500 pb-4">
                                    ⚙️ Punktesystem
                                </h2>
                                <x-scoresystem-form :scoresystem="$scoresystem"
                                />
                            </div>
                        </div>

                        {{-- SLIDE 2: Schulen --}}
                        <div class="w-[16.666%] flex-shrink-0 opacity-0 transition-opacity duration-300 carousel-slide">
                            <div class="px-4 sm:px-2 sm:py-6 min-h-[500px] sm:min-h-[300px]">
                                <h2 class="text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 border-b-2 border-purple-400 pb-4">
                                    🏫 Schulen
                                </h2>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Neue Schule anlegen</h3>
                                        <x-school-form />
                                    </div>
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Schulen</h3>
                                        @if($schools->count() > 0)
                                            <ul class="space-y-2">
                                                @foreach($schools as $school)
                                                    <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                        <span class="text-gray-700">{{ $school->name }}</span>
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
                            </div>
                        </div>

                        {{-- SLIDE 3: Klassen --}}
                        <div class="w-[16.666%] flex-shrink-0 opacity-0 transition-opacity duration-300 carousel-slide">
                            <div class="px-4sm:px-2 sm:py-6 min-h-[500px] sm:min-h-[300px]">
                                <h2 class="text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 border-b-2 border-green-500 pb-4">
                                    👥 Klassen
                                </h2>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Neue Klasse anlegen</h3>
                                        @if($schools->count() > 0)
                                            <x-klasse-form :schools="$schools" />
                                        @else
                                            <p class="text-red-600 italic">Bitte zuerst eine Schule anlegen!</p>
                                        @endif
                                    </div>
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Klassen</h3>
                                        @if($klasses->count() > 0)
                                            <ul class="space-y-2">
                                                @foreach($klasses as $klasse)
                                                    <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                        <div>
                                                            <span class="text-gray-700">{{ $klasse->name }}</span>
                                                            <span class="text-xs text-gray-500 ml-2">({{ $klasse->school->name ?? 'Keine Schule' }})</span>
                                                            <br>
                                                            <span class="text-xs text-blue-500 ml-2">Password: {{ $klasse->password }}</span>
                                                        </div>
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
                            </div>
                        </div>

                        {{-- SLIDE 4: Teams --}}
                        <div class="w-[16.666%] flex-shrink-0 opacity-0 transition-opacity duration-300 carousel-slide">
                            <div class="px-4 sm:px-2 sm:py-6 min-h-[500px] sm:min-h-[300px]">
                                <h2 class="text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 border-b-2 border-pink-500 pb-4">
                                    🏆 Teams
                                </h2>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Neues Team anlegen</h3>
                                        @if($klasses->count() > 0)
                                            <x-team-form :klasses="$klasses" />
                                        @else
                                            <p class="text-red-600 italic">Bitte zuerst eine Klasse anlegen!</p>
                                        @endif
                                    </div>
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
                            </div>
                        </div>

                        {{-- SLIDE 5: Disziplinen --}}
                        <div class="w-[16.666%] flex-shrink-0 opacity-0 transition-opacity duration-300 carousel-slide">
                            <div class="px-4 sm:px-2 sm:py-6 min-h-[500px] sm:min-h-[300px]">
                                <h2 class="text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 border-b-2 border-orange-400 pb-4">
                                    ⚡ Disziplinen
                                </h2>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Neue Disziplin anlegen</h3>
                                        @if($klasses->count() > 0)
                                            <x-discipline-form :disciplineklasses="$disciplineklasses" />
                                        @else
                                            <p class="text-red-600 italic">Bitte zuerst eine Klasse anlegen!</p>
                                        @endif
                                    </div>
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Disziplinen</h3>
                                        @if($disciplines->count() > 0)
                                            <ul class="space-y-2">
                                                @foreach($disciplines as $discipline)
                                                    <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                        <div>
                                                            <span class="text-gray-700">{{ $discipline->name }}</span>
                                                            <span class="text-xs text-gray-500 ml-2">({{ $discipline->klasse->name ?? 'Keine Klasse' }})</span>
                                                            <br>
                                                            @if($discipline->higher_is_better)
                                                                <p class="text-xs text-green-500">Höher ist Besser</p>
                                                            @else
                                                                <p class="text-xs text-red-500">Niedriger ist Besser</p>
                                                            @endif

                                                        </div>
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
                            </div>
                        </div>

                        {{-- SLIDE 6: Archiv --}}
                        <div class="w-[16.666%] flex-shrink-0 opacity-0 transition-opacity duration-300 carousel-slide">
                            <div class="px-4 sm:px-2 sm:py-6 min-h-[500px] sm:min-h-[300px]">
                                <h2 class="text-3xl sm:text-2xl font-semibold mb-8 sm:mb-6 text-center text-gray-800 border-b-2 border-purple-500 pb-4">
                                    📚 Archiv
                                </h2>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Neues Archiv erstellen</h3>
                                        <p class="text-gray-600 mb-4 text-sm">Erstellen Sie ein Archiv mit allen aktuellen Daten der CampusOlympiade.</p>

                                        <form action="{{ route('archive.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="archive_name" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Archiv Name *
                                                </label>
                                                <input type="text"
                                                       id="archive_name"
                                                       name="name"
                                                       required
                                                       placeholder="z.B. CampusOlympiade 2024"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                            </div>

                                            <div class="mb-4">
                                                <label for="archive_description" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Beschreibung (optional)
                                                </label>
                                                <textarea id="archive_description"
                                                          name="description"
                                                          rows="3"
                                                          placeholder="Zusätzliche Informationen zum Archiv..."
                                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
                                            </div>

                                            <button type="submit"
                                                    class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-2 px-4 rounded-lg hover:from-purple-600 hover:to-blue-600 transition-colors duration-200 font-medium">
                                                📚 Archiv erstellen
                                            </button>
                                        </form>
                                    </div>

                                    <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Vorhandene Archive</h3>
                                        @if($archives->count() > 0)
                                            <ul class="space-y-2">
                                                @foreach($archives as $archive)
                                                    <li class="flex items-center justify-between bg-white p-3 rounded shadow-sm border border-gray-100">
                                                        <div class="flex-1">
                                                            <div class="flex items-center gap-2">
                                                                <span class="text-gray-700 font-medium">{{ $archive->name }}</span>
                                                                <a href="{{ route('archive.show', $archive->id) }}"
                                                                   class="text-blue-500 hover:text-blue-700 transition-colors duration-150"
                                                                   title="Archiv anzeigen">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            <div class="text-xs text-gray-500 mt-1">
                                                                {{ $archive->archived_date->format('d.m.Y') }}
                                                                @if($archive->description)
                                                                    <br>{{ Str::limit($archive->description, 50) }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <form action="{{ route('archive.destroy', $archive->id) }}" method="POST" onsubmit="return confirm('Archiv {{ $archive->name }} wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden!');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-150 p-1 rounded hover:bg-red-100" title="Archiv löschen">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="italic text-gray-500">Keine Archive vorhanden.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Dot Navigation --}}
                <div class="flex justify-center gap-2 mt-6" id="carouselDots">
                    <button class="w-3 h-3 rounded-full border-0 bg-indigo-600 cursor-pointer transition-all duration-200 scale-125 dot active" data-slide="0" aria-label="Punktesystem"></button>
                    <button class="w-3 h-3 rounded-full border-0 bg-gray-400 cursor-pointer transition-all duration-200 hover:bg-gray-500 hover:scale-110 dot" data-slide="1" aria-label="Schulen"></button>
                    <button class="w-3 h-3 rounded-full border-0 bg-gray-400 cursor-pointer transition-all duration-200 hover:bg-gray-500 hover:scale-110 dot" data-slide="2" aria-label="Klassen"></button>
                    <button class="w-3 h-3 rounded-full border-0 bg-gray-400 cursor-pointer transition-all duration-200 hover:bg-gray-500 hover:scale-110 dot" data-slide="3" aria-label="Teams"></button>
                    <button class="w-3 h-3 rounded-full border-0 bg-gray-400 cursor-pointer transition-all duration-200 hover:bg-gray-500 hover:scale-110 dot" data-slide="4" aria-label="Disziplinen"></button>
                    <button class="w-3 h-3 rounded-full border-0 bg-gray-400 cursor-pointer transition-all duration-200 hover:bg-gray-500 hover:scale-110 dot" data-slide="5" aria-label="Archiv"></button>
                </div>

                {{-- Progress Indicator --}}
                <div class="text-center mt-4">
                    <span class="text-sm text-gray-600" id="slideIndicator">1 von 6</span>
                </div>
            </div>

        </div>
    </div>
</x-layout>
