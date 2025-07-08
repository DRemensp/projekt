@php use App\Services\SchoolColorService; @endphp
<x-layout>
    <x-slot:heading>Live Rangliste</x-slot:heading>

    <!-- notwendig weil Tailwind scheiße ist -->
    <div class="hidden bg-blue-100 bg-green-100 bg-orange-100 bg-purple-100 text-blue-700 text-green-700 text-orange-700 text-purple-700 border-blue-500 border-green-500 border-orange-500 border-purple-500"></div>

    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <div class="bg-white rounded-2xl shadow-xl p-5 mb-8">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-emerald-600 bg-clip-text text-transparent mb-4">
                        Live Rangliste
                    </h1>
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
            </div>

            <!-- Navigation Tabs -->
            <div class="flex justify-center mb-8 ">
                <nav class="bg-white rounded-full shadow-lg p-1 border border-gray-200">
                    <div class="flex space-x-1">
                        <button onclick="showSection('schools')" class="ranking-tab px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 text-white">
                            Schulen
                        </button>
                        <button onclick="showSection('klasses')" class="ranking-tab px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 hover:text-indigo-600">
                            Klassen
                        </button>
                        <button onclick="showSection('teams')" class="ranking-tab px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 hover:text-indigo-600">
                            Teams
                        </button>
                        <button onclick="showSection('disciplines')" class="ranking-tab px-6 py-3 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 hover:text-indigo-600">
                            Disziplinen
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Schulen Ranking -->
            @if($schools->count() > 0)
                <div id="schools-section" class="ranking-section">
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">🏫 Schulen Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center items-end mb-12">
                            <div class="flex items-end space-x-8">
                                <!-- 2. Platz (Links) -->
                                @if(isset($schools[1]))
                                    @php $colors = SchoolColorService::getColorClasses($schools[1]->id); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-32 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($schools[1]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $schools[1]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- 1. Platz (Mitte) -->
                                @if(isset($schools[0]))
                                    @php $colors = SchoolColorService::getColorClasses($schools[0]->id); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-40 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($schools[0]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $schools[0]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- 3. Platz (Rechts) -->
                                @if(isset($schools[2]))
                                    @php $colors = SchoolColorService::getColorClasses($schools[2]->id); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-28 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($schools[2]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $schools[2]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Weitere Schulen -->
                        @if($schools->count() > 3)
                            <div class="space-y-3">
                                @foreach($schools->slice(3) as $index => $school)
                                    @php $colors = SchoolColorService::getColorClasses($school->id); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-shadow">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-gray-700 text-sm">
                                                {{ $index + 4 }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $school->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }}">{{ $school->score }}</div>
                                            <div class="text-xs text-gray-500">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Klassen Ranking -->
            @if($klasses->count() > 0)
                <div id="klasses-section" class="ranking-section hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">🎯 Klassen Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center items-end mb-12">
                            <div class="flex items-end space-x-8">
                                <!-- 2. Platz (Links) -->
                                @if(isset($klasses[1]))
                                    @php $colors = SchoolColorService::getColorClasses($klasses[1]->school_id ?? 0); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-32 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($klasses[1]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $klasses[1]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- 1. Platz (Mitte) -->
                                @if(isset($klasses[0]))
                                    @php $colors = SchoolColorService::getColorClasses($klasses[0]->school_id ?? 0); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-40 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($klasses[0]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $klasses[0]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- 3. Platz (Rechts) -->
                                @if(isset($klasses[2]))
                                    @php $colors = SchoolColorService::getColorClasses($klasses[2]->school_id ?? 0); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-28 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($klasses[2]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $klasses[2]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Weitere Klassen -->
                        @if($klasses->count() > 3)
                            <div class="space-y-3">
                                @foreach($klasses->slice(3) as $index => $klasse)
                                    @php $colors = SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-shadow">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-gray-700 text-sm">
                                                {{ $index + 4 }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $klasse->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }}">{{ $klasse->score }}</div>
                                            <div class="text-xs text-gray-500">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Teams Ranking -->
            @if($teams->count() > 0)
                <div id="teams-section" class="ranking-section hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">🏆 Teams Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center items-end mb-12">
                            <div class="flex items-end space-x-8">
                                <!-- 2. Platz (Links) -->
                                @if(isset($teams[1]))
                                    @php $colors = SchoolColorService::getColorClasses($teams[1]->klasse->school_id ?? 0); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-32 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($teams[1]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $teams[1]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- 1. Platz (Mitte) -->
                                @if(isset($teams[0]))
                                    @php $colors = SchoolColorService::getColorClasses($teams[0]->klasse->school_id ?? 0); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-40 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($teams[0]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $teams[0]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- 3. Platz (Rechts) -->
                                @if(isset($teams[2]))
                                    @php $colors = SchoolColorService::getColorClasses($teams[2]->klasse->school_id ?? 0); @endphp
                                    <div class="flex flex-col items-center space-y-3">
                                        <div class="text-4xl">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} h-28 w-28 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($teams[2]->name, 12) }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $teams[2]->score }}P</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Weitere Teams -->
                        @if($teams->count() > 3)
                            <div class="space-y-3">
                                @foreach($teams->slice(3) as $index => $team)
                                    @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-shadow">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-gray-700 text-sm">
                                                {{ $index + 4 }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $team->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }}">{{ $team->score }}</div>
                                            <div class="text-xs text-gray-500">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Team-Suche -->
                        <div class="max-w-2xl mx-auto mt-12">
                            <div class="bg-white rounded-lg shadow-md p-6 border-2 border-gray-300">
                                <label for="team-search-input" class="block text-sm font-medium text-gray-700 mb-2">
                                    Team suchen:
                                </label>
                                <input type="text"
                                       id="team-search-input"
                                       placeholder="Teamname eingeben..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            {{--suchergebnisse --}}
                            <div id="team-search-results" class="mt-4">

                            </div>
                        </div>

                    </div>
                </div>
            @endif

            <!-- Disziplinen Ranking -->
            @if(!empty($bestTeamsPerDiscipline))
                <div id="disciplines-section" class="ranking-section hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">🎯 Beste Teams pro Disziplin</h2>

                        <div class="space-y-4">
                            @foreach($bestTeamsPerDiscipline as $champion)
                                <div class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                                    <div class="absolute top-4 right-4">
                                        <span class="text-2xl">🏆</span>
                                    </div>

                                    <div class="p-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full flex items-center justify-center text-2xl font-bold text-white">
                                                👑
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-xl font-bold text-gray-800 mb-1">
                                                    {{ $champion['discipline_name'] ?? 'Disziplin ' . $champion['discipline_id'] }}
                                                </h3>
                                                <p class="text-lg font-semibold text-orange-700 mb-2">
                                                    Team: {{ $champion['team_name'] ?? 'Team ' . $champion['team_id'] }}
                                                </p>
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    <span class="text-lg font-bold text-orange-800">{{ $champion['best_score'] }}</span>
                                                    <span class="text-sm text-gray-500">Bestleistung</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- JavaScript für Tab-Navigation und externe Suchfunktionalität -->
    <script>
        // Daten für laufzettel-search.js bereitstellen
        const allTeamsData = @json($teamsForJs ?? []);
        const colorMap = @json($colorMapForJs ?? ['default' => []]);

        // Tab Navigation
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.ranking-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show selected section
            document.getElementById(sectionName + '-section').classList.remove('hidden');

            // Update tab styles
            document.querySelectorAll('.ranking-tab').forEach(tab => {
                tab.classList.remove('bg-indigo-600', 'text-white');
                tab.classList.add('text-gray-600', 'hover:text-indigo-600');
            });

            // Highlight active tab
            event.target.classList.remove('text-gray-600', 'hover:text-indigo-600');
            event.target.classList.add('bg-indigo-600', 'text-white');
        }
    </script>

    <!-- Import der laufzettel-search.js für Suchfunktionalität -->
    @vite(['resources/js/laufzettel-search.js'])
</x-layout>
