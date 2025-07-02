@php use App\Services\SchoolColorService; @endphp
<x-layout>
    <x-slot:heading>Ranking Dashboard</x-slot:heading>

    <!-- notwendig weil Tailwind scheiße ist -->
    <div class="hidden bg-blue-100 bg-green-100 bg-orange-100 bg-purple-100 text-blue-700 text-green-700 text-orange-700 text-purple-700 border-blue-500 border-green-500 border-orange-500 border-purple-500"></div>

    <div class="bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white shadow-xl rounded-lg p-8">

                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-indigo-700 mb-3">Rangliste</h1>
                    <p class="text-xl text-gray-600 mb-6">Willkommen zur aktuellen Übersicht aller Wertungen!</p>

                    <div class="max-w-3xl mx-auto bg-blue-50 border border-blue-200 p-4 rounded-lg flex items-start space-x-3">
                        <svg class="h-6 w-6 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <div class="text-sm text-blue-800 text-left">
                            <p class="font-semibold mb-1">Wie werden die Punkte berechnet?</p>
                            <ul class="list-disc ml-4 space-y-1 text-blue-700">
                                <li><strong>Teams:</strong> Erhalten Punkte basierend auf ihrer Platzierung in jeder Disziplin.</li>
                                <li><strong>Klassen & Schulen:</strong> Der Gesamtscore ergibt sich aus dem Durchschnitt der Punkte aller zugehörigen Teams.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Schulen ranking -->
                @if($schools->count() > 0)
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Schulen Rangliste</h2>
                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach($schools->take(3) as $index => $school)
                                @php $colors = SchoolColorService::getColorClasses($school->id); @endphp
                                <div class="{{ $colors['bg'] }} border-t-4 {{ $colors['border'] }} rounded-lg shadow-md p-6 text-center hover:scale-105 transition-transform">
                                    <div class="text-3xl mb-3">{{ ['🥇', '🥈', '🥉'][$index] }}</div>
                                    <div class="text-sm font-semibold {{ $colors['text-subtle'] }} uppercase mb-2">{{ ($index + 1) }}. Platz</div>
                                    <p class="text-lg font-semibold text-gray-800 truncate">{{ $school->name }}</p>
                                    <p class="{{ $colors['text-points'] }} font-bold mt-1">{{ $school->score }} Punkte</p>
                                </div>
                            @endforeach
                        </div>
                        <!-- weitere Teams reinladen mit farben -->
                        @if($schools->count() > 3)
                            <div class="mt-8">
                                <details class="bg-white rounded-lg shadow p-4 border">
                                    <summary class="font-semibold cursor-pointer text-gray-700 hover:text-black">
                                        Weitere Schulen anzeigen
                                        <svg class="h-5 w-5 inline ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </summary>
                                    <div class="mt-4 space-y-3">
                                        @foreach($schools->slice(3) as $index => $school)
                                            @php $colors = SchoolColorService::getColorClasses($school->id); @endphp
                                            <div class="flex justify-between items-center {{ $colors['bg-light'] }} p-3 rounded border-l-4 {{ $colors['border-light'] }}">
                                                <div class="flex items-center">
                                                    <span class="text-sm text-gray-500 w-8 mr-3">{{ $index + 1}}.</span>
                                                    <span class="text-gray-800 truncate">{{ $school->name }}</span>
                                                </div>
                                                <span class="font-semibold {{ $colors['text-points'] }} text-sm">{{ $school->score }} Punkte</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @endif
                    </section>
                @endif

                <!-- Klassen Ranking -->
                @if($klasses->count() > 0)
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Klassen Rangliste</h2>
                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach($klasses->take(3) as $index => $klasse)
                                @php $colors = SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                <div class="{{ $colors['bg'] }} border-t-4 {{ $colors['border'] }} rounded-lg shadow-md p-6 text-center hover:scale-105 transition-transform">
                                    <div class="text-3xl mb-3">{{ ['🥇', '🥈', '🥉'][$index] }}</div>
                                    <div class="text-sm font-semibold {{ $colors['text-subtle'] }} uppercase mb-2">{{ ($index+1) }}. Platz</div>
                                    <p class="text-lg font-semibold text-gray-800 truncate">{{ $klasse->name }}</p>
                                    <p class="{{ $colors['text-points'] }} font-bold mt-1">{{ $klasse->score }} Punkte</p>
                                </div>
                            @endforeach
                        </div>
                        <!-- weitere Klassen reinladen mit farben -->
                        @if($klasses->count() > 3)
                            <div class="mt-8">
                                <details class="bg-white rounded-lg shadow p-4 border">
                                    <summary class="font-semibold cursor-pointer text-gray-700 hover:text-black">
                                        Weitere Klassen anzeigen
                                    </summary>
                                    <div class="mt-4 space-y-3">
                                        @foreach($klasses->slice(3) as $index => $klasse)
                                            @php $colors = SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                            <div class="flex justify-between items-center {{ $colors['bg-light'] }} p-3 rounded border-l-4 {{ $colors['border-light'] }}">
                                                <div class="flex items-center">
                                                    <span class="text-sm text-gray-500 w-8 mr-3">{{ $index + 1}}.</span>
                                                    <span class="text-gray-800 truncate">{{ $klasse->name }}</span>
                                                </div>
                                                <span class="font-semibold {{ $colors['text-points'] }} text-sm">{{ $klasse->score }} Punkte</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @endif
                    </section>
                @endif

                <!-- Top 3 Teams -->
                @if($teams->count() > 0)
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Top 3 Teams</h2>
                        <div class="grid md:grid-cols-3 gap-6">
                            @foreach($teams->take(3) as $index => $team)
                                @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                <div class="{{ $colors['bg'] }} border-t-4 {{ $colors['border'] }} rounded-lg shadow-md p-6 text-center hover:scale-105 transition-transform">
                                    <div class="text-3xl mb-3">{{ ['🥇', '🥈', '🥉'][$index] }}</div>
                                    <div class="text-sm font-semibold {{ $colors['text-subtle'] }} uppercase mb-2">{{ ($index + 1) }}. Platz</div>
                                    <p class="text-lg font-semibold text-gray-800 truncate">{{ $team->name }}</p>
                                    <p class="{{ $colors['text-points'] }} font-bold mt-1">{{ $team->score }} Punkte</p>
                                </div>
                            @endforeach
                        </div>
                            <!-- weitere Teams reinladen mit farben -->
                        @if($teams->count() > 3)
                            <div class="mt-8">
                                <details class="bg-white rounded-lg shadow p-4 border">
                                    <summary class="font-semibold cursor-pointer text-gray-700 hover:text-black">
                                        Alle Teams anzeigen ({{ $teams->count() - 3 }} weitere)
                                    </summary>
                                    <div class="mt-4 space-y-3">
                                        @foreach($teams->slice(3) as $index => $team)
                                            @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                            <div class="flex justify-between items-center {{ $colors['bg-light'] }} p-3 rounded border-l-4 {{ $colors['border-light'] }}">
                                                <div class="flex items-center min-w-0 flex-1">
                                                    <span class="text-sm text-gray-500 w-8 mr-3">{{ $index + 1 }}.</span>
                                                    <div class="min-w-0">
                                                        <span class="text-gray-800 font-medium block truncate">{{ $team->name }}</span>
                                                        <span class="text-xs text-gray-500 block truncate">{{ $team->klasse->name ?? 'N/A' }} • {{ $team->klasse->school->name ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <span class="font-semibold {{ $colors['text-points'] }} text-sm ml-2">{{ $team->score }} Punkte</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @endif
                    </section>
                @endif

                @if(($schools->count() > 0 || $klasses->count() > 0 || $teams->count() > 0) && (!empty($bestTeamsPerDiscipline) || $teams->count() > 0))
                    <hr class="my-8 border-gray-200">
                @endif

                <!-- Ermittlung von besten teams pro Disziplin -->
                @if(!empty($bestTeamsPerDiscipline))
                    <section class="mb-12">
                        <details open>
                            <summary class="text-xl font-semibold mb-4 cursor-pointer text-gray-700 hover:text-black flex justify-between items-center">
                                <span>Bestes Team pro Disziplin</span>
                                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </summary>
                            <div class="overflow-x-auto mt-4">
                                <table class="min-w-full bg-white shadow-lg rounded-lg border">
                                    <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Disziplin</th>
                                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Bestes Team</th>
                                        <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Punktzahl</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                    @foreach($bestTeamsPerDiscipline as $best)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-4 text-sm text-gray-700">{{ $best['discipline_name'] ?? 'Disziplin ' . $best['discipline_id'] }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-700 font-medium">{{ $best['team_name'] ?? 'Team ' . $best['team_id'] }}</td>
                                            <td class="py-3 px-4 text-sm text-indigo-700 font-semibold">{{ $best['best_score'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                    </section>
                @endif

                <!-- Team suchzeile (noch mit template elemente) -->
                @if(isset($teamsForJs) && isset($colorMapForJs) && $teams->count() > 0)
                    <section>
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Team-Suche</h2>
                        <div class="mb-4 relative">
                            <input type="text" id="team-search-input" placeholder="Team suchen..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div id="team-search-results" class="overflow-x-auto min-h-[3rem]">
                            <p class="text-center text-gray-500 italic py-4">Gib einen Teamnamen ein, um nach Teams zu suchen...</p>
                        </div>
                    </section>
                @endif

            </div>
        </div>
    </div>

    <script>
        const allTeamsData = @json($teamsForJs ?? []);
        const colorMap = @json($colorMapForJs ?? ['default' => []]);
    </script>

</x-layout>
