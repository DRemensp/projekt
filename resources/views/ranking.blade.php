<x-layout>
    <x-slot:heading>
        Ranking Dashboard
    </x-slot:heading>


    <div class="hidden
        bg-blue-100 bg-blue-50 text-blue-700 text-blue-600 text-blue-800 border-blue-500 border-blue-300 hover:text-blue-900 hover:border-blue-700
        bg-green-100 bg-green-50 text-green-700 text-green-600 text-green-800 border-green-500 border-green-300 hover:text-green-900 hover:border-green-700
        bg-orange-100 bg-orange-50 text-orange-700 text-orange-600 text-orange-800 border-orange-500 border-orange-300 hover:text-orange-900 hover:border-orange-700
        bg-purple-100 bg-purple-50 text-purple-700 text-purple-600 text-purple-800 border-purple-500 border-purple-300 hover:text-purple-900 hover:border-purple-700
        "></div>




    {{-- Haupt-Container mit leicht grauem Hintergrund --}}
    <div class="bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Container für den Inhalt: Weiß mit Schatten --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Header-Bereich OHNE Button --}}
                    <div class="text-center mb-12">
                        <h1 class="text-4xl font-bold text-indigo-700 mb-3">Rangliste</h1>
                        <p class="text-xl text-gray-600 mb-6">Willkommen zur aktuellen Übersicht aller Wertungen!</p>
                        {{-- Informations-Box --}}
                        <div class="mt-6 max-w-3xl mx-auto bg-blue-50 border border-blue-200 p-4 rounded-lg shadow-sm text-left flex items-start space-x-3">
                            <div class="flex-shrink-0 pt-0.5"><svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg></div>
                            <div class="text-sm text-blue-800"><p class="font-semibold mb-1">Wie werden die Punkte berechnet?</p><ul class="list-disc list-outside ml-4 space-y-1 text-blue-700"><li><span class="font-semibold">Teams:</span> Erhalten Punkte basierend auf ihrer Platzierung in jeder Disziplin.</li><li><span class="font-semibold">Klassen & Schulen:</span> Der Gesamtscore ergibt sich aus dem Durchschnitt der Punkte aller zugehörigen Teams. Dies sorgt für einen fairen Vergleich.</li></ul></div>
                        </div>
                    </div>

                    {{-- Bereich für die Ranglisten (Schools, Klassen, Teams Top 3) --}}
                    <div class="space-y-12 mt-8">
                        {{-- ==================== SCHOOLS ==================== --}}
                        @if($schools->count() > 0)
                            <section>
                                <h2 class="text-2xl font-bold mb-6 text-gray-800">Schulen Rangliste</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    @php $topSchools = $schools->take(3); @endphp
                                    @foreach($topSchools as $index => $school)
                                        @php $colors = \App\Services\SchoolColorService::getColorClasses($school->id); @endphp
                                        <div class="{{ $colors['bg'] }} {{ $colors['border'] }} border-t-4 rounded-lg shadow-md p-6 text-center transition-transform transform hover:scale-105">
                                            <div class="text-3xl mb-3">{{ ['🥇', '🥈', '🥉'][$index] ?? '' }}</div>
                                            <div class="text-sm font-semibold {{ $colors['text-subtle'] }} uppercase tracking-wider mb-2">{{ ['1. Platz', '2. Platz', '3. Platz'][$index] ?? '' }}</div>
                                            <p class="text-lg font-semibold text-gray-800 truncate" title="{{ $school->name }}">{{ $school->name }}</p>
                                            <p class="{{ $colors['text-points'] }} font-bold mt-1">{{ $school->score }} Punkte</p>
                                        </div>
                                    @endforeach
                                </div>
                                @if($schools->count() > 3)
                                    <div class="mt-8">
                                        @php
                                            $firstOtherSchoolId = $schools->slice(3)->first()->id ?? null;
                                            $detailColors = \App\Services\SchoolColorService::getColorClasses($firstOtherSchoolId);
                                        @endphp
                                        <details class=" bg-white rounded-lg shadow p-4 border {{ $detailColors['border-light'] }}">
                                            <summary class="text-md font-semibold cursor-pointer {{ $detailColors['text'] }} {{ $detailColors['text-hover'] }} list-none">
                                                <span class="inline-block border-b-2 border-transparent {{ $detailColors['border-hover'] }}">Weitere Schulen anzeigen</span>
                                                <svg class="h-5 w-5 inline-block ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                            </summary>
                                            <div class="mt-4 space-y-3">
                                                @foreach($schools->slice(3) as $index => $school)
                                                    @php $colors = \App\Services\SchoolColorService::getColorClasses($school->id); @endphp
                                                    <div class="flex justify-between items-center {{ $colors['bg-light'] }} p-3 rounded-md border-l-4 {{ $colors['border-light'] }}">
                                                        <div class="flex items-center min-w-0">
                                                            <span class="text-sm font-medium text-gray-500 w-8 text-right mr-3 flex-shrink-0">{{ $index + 4 }}.</span>
                                                            <span class="text-gray-800 truncate" title="{{ $school->name }}">{{ $school->name }}</span>
                                                        </div>
                                                        <span class="font-semibold {{ $colors['text-points'] }} text-sm whitespace-nowrap ml-2">{{ $school->score }} Punkte</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    </div>
                                @endif
                            </section>
                        @endif

                        {{-- ==================== KLASSEN ==================== --}}
                        @if($klasses->count() > 0)
                            <section>
                                <h2 class="text-2xl font-bold mb-6 text-gray-800">Klassen Rangliste</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    @php $topKlasses = $klasses->take(3); @endphp
                                    @foreach($topKlasses as $index => $klasse)
                                        @php $colors = \App\Services\SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                        <div class="{{ $colors['bg'] }} {{ $colors['border'] }} border-t-4 rounded-lg shadow-md p-6 text-center transition-transform transform hover:scale-105">
                                            <div class="text-3xl mb-3">{{ ['🥇', '🥈', '🥉'][$index] ?? '' }}</div>
                                            <div class="text-sm font-semibold {{ $colors['text-subtle'] }} uppercase tracking-wider mb-2">{{ ['1. Platz', '2. Platz', '3. Platz'][$index] ?? '' }}</div>
                                            <p class="text-lg font-semibold text-gray-800 truncate" title="{{ $klasse->name }}">{{ $klasse->name }}</p>
                                            <p class="{{ $colors['text-points'] }} font-bold mt-1">{{ $klasse->score }} Punkte</p>
                                        </div>
                                    @endforeach
                                </div>
                                @if($klasses->count() > 3)
                                    <div class="mt-8">
                                        @php
                                            $firstOtherKlasseSchoolId = $klasses->slice(3)->first()->school_id ?? null;
                                            $detailColors = \App\Services\SchoolColorService::getColorClasses($firstOtherKlasseSchoolId);
                                        @endphp
                                        <details class="bg-white rounded-lg shadow p-4 border {{ $detailColors['border-light'] }}">
                                            <summary class="text-md font-semibold cursor-pointer {{ $detailColors['text'] }} {{ $detailColors['text-hover'] }} list-none">
                                                <span class="inline-block border-b-2 border-transparent {{ $detailColors['border-hover'] }}">Weitere Klassen anzeigen</span>
                                                <svg class="h-5 w-5 inline-block ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                            </summary>
                                            <div class="mt-4 space-y-3">
                                                @foreach($klasses->slice(3) as $index => $klasse)
                                                    @php $colors = \App\Services\SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                                    <div class="flex justify-between items-center {{ $colors['bg-light'] }} p-3 rounded-md border-l-4 {{ $colors['border-light'] }}">
                                                        <div class="flex items-center min-w-0">
                                                            <span class="text-sm font-medium text-gray-500 w-8 text-right mr-3 flex-shrink-0">{{ $index + 4 }}.</span>
                                                            <span class="text-gray-800 truncate" title="{{ $klasse->name }}">{{ $klasse->name }}</span>
                                                        </div>
                                                        <span class="font-semibold {{ $colors['text-points'] }} text-sm whitespace-nowrap ml-2">{{ $klasse->score }} Punkte</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    </div>
                                @endif
                            </section>
                        @endif

                        {{-- ==================== TEAMS (TOP 3) ==================== --}}
                        @if($teams->count() > 0)
                            <section>
                                <h2 class="text-2xl font-bold mb-6 text-gray-800">Top 3 Teams</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    @php $topTeams = $teams->take(3); @endphp
                                    @foreach($topTeams as $index => $team)
                                        @php $colors = \App\Services\SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                        <div class="{{ $colors['bg'] }} {{ $colors['border'] }} border-t-4 rounded-lg shadow-md p-6 text-center transition-transform transform hover:scale-105">
                                            <div class="text-3xl mb-3">{{ ['🥇', '🥈', '🥉'][$index] ?? '' }}</div>
                                            <div class="text-sm font-semibold {{ $colors['text-subtle'] }} uppercase tracking-wider mb-2">{{ ['1. Platz', '2. Platz', '3. Platz'][$index] ?? '' }}</div>
                                            <p class="text-lg font-semibold text-gray-800 truncate" title="{{ $team->name }}">{{ $team->name }}</p>
                                            <p class="{{ $colors['text-points'] }} font-bold mt-1">{{ $team->score }} Punkte</p>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        {{-- Trennlinie --}}
                        @if(($schools->count() > 0 || $klasses->count() > 0 || $teams->count() > 0) && !empty($bestTeamsPerDiscipline) || $teams->count() > 0)
                            <hr class="my-8 border-gray-200">
                        @endif

                        {{-- ==================== TABELLEN / SUCHE ==================== --}}
                        <div class="space-y-12">
                            {{-- Bestes Team pro Disziplin --}}
                            @if(!empty($bestTeamsPerDiscipline))
                                <section>
                                    <details open> <summary class="text-xl font-semibold mb-4 cursor-pointer text-gray-700 hover:text-black list-none flex justify-between items-center"> <span>Bestes Team pro Disziplin</span> <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg> </summary> <div class="overflow-x-auto mt-4"> <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200"> <thead class="bg-gray-100"><tr><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Disziplin</th><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bestes Team</th><th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Punktzahl</th></tr></thead> <tbody class="divide-y divide-gray-200"> @foreach($bestTeamsPerDiscipline as $best) <tr class="hover:bg-gray-50"><td class="py-3 px-4 text-sm text-gray-700">{{ $best['discipline_name'] ?? 'Disziplin ' . $best['discipline_id'] }}</td><td class="py-3 px-4 text-sm text-gray-700 font-medium">{{ $best['team_name'] ?? 'Team ' . $best['team_id'] }}</td><td class="py-3 px-4 text-sm text-indigo-700 font-semibold">{{ $best['best_score'] }}</td></tr> @endforeach </tbody> </table> </div> </details>
                                </section>
                            @endif

                            {{-- Team-Suche --}}
                            @if(isset($teamsForJs) && isset($colorMapForJs) && $teams->count() > 0)
                                <section>
                                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Team-Suche</h2>
                                    <div class="mb-4 relative">
                                        <input
                                            type="text"
                                            id="team-search-input"
                                            placeholder="Teamnamen eingeben..."
                                            aria-label="Teamnamen suchen"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                        >
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>

                                    <div id="team-search-results" class="overflow-x-auto min-h-[5rem]">
                                        <p class="text-center text-gray-500 italic py-4">Findest dein schlecht performendes Team nicht in den Top 3? GOTCHA, einfach nach dem namen des Teams hier suchen.</p>
                                    </div>
                                </section>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daten für JavaScript werden hier eingebettet --}}
    <script>
        const allTeamsData = @json($teamsForJs ?? []);
        const colorMap = @json($colorMapForJs ?? ['default' => []]);
    </script>

</x-layout>
