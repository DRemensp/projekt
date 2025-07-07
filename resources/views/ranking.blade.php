@php use App\Services\SchoolColorService; @endphp
<x-layout>
    <x-slot:heading>Live Rangliste</x-slot:heading>

    <!-- notwendig weil Tailwind scheiße ist -->
    <div class="hidden bg-blue-100 bg-green-100 bg-orange-100 bg-purple-100 text-blue-700 text-green-700 text-orange-700 text-purple-700 border-blue-500 border-green-500 border-orange-500 border-purple-500"></div>

    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
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
            <div class="flex justify-center mb-8">
                <nav class="bg-white rounded-full shadow-lg p-2 border border-gray-200">
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
                        <div class="flex justify-center items-end mb-8 space-x-4">
                            @foreach($schools->take(3) as $index => $school)
                                @php
                                    $colors = SchoolColorService::getColorClasses($school->id);
                                    $heights = ['h-32', 'h-40', 'h-28'];
                                    $positions = [1, 0, 2]; // 2nd, 1st, 3rd
                                @endphp
                                <div class="flex flex-col items-center {{ $positions[$index] == 0 ? 'order-2' : ($positions[$index] == 1 ? 'order-1' : 'order-3') }}">
                                    <div class="text-4xl mb-2">{{ ['🥇', '🥈', '🥉'][$index] }}</div>
                                    <div class="bg-gradient-to-t {{ $colors['bg'] }} {{ $heights[$positions[$index]] }} w-24 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-2">
                                        <div class="text-center">
                                            <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">{{ $index + 1 }}.</div>
                                            <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($school->name, 10) }}</div>
                                            <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $school->score }}P</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Weitere Schulen -->
                        @if($schools->count() > 3)
                            <div class="space-y-2">
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
                        <div class="flex justify-center items-end mb-8 space-x-4">
                            @foreach($klasses->take(3) as $index => $klasse)
                                @php
                                    $colors = SchoolColorService::getColorClasses($klasse->school_id ?? 0);
                                    $heights = ['h-32', 'h-40', 'h-28'];
                                    $positions = [1, 0, 2];
                                @endphp
                                <div class="flex flex-col items-center {{ $positions[$index] == 0 ? 'order-2' : ($positions[$index] == 1 ? 'order-1' : 'order-3') }}">
                                    <div class="text-4xl mb-2">{{ ['🥇', '🥈', '🥉'][$index] }}</div>
                                    <div class="bg-gradient-to-t {{ $colors['bg'] }} {{ $heights[$positions[$index]] }} w-24 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-2">
                                        <div class="text-center">
                                            <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">{{ $index + 1 }}.</div>
                                            <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($klasse->name, 10) }}</div>
                                            <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $klasse->score }}P</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Weitere Klassen -->
                        @if($klasses->count() > 3)
                            <div class="space-y-2">
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
                        <div class="flex justify-center items-end mb-8 space-x-4">
                            @foreach($teams->take(3) as $index => $team)
                                @php
                                    $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0);
                                    $heights = ['h-32', 'h-40', 'h-28'];
                                    $positions = [1, 0, 2];
                                @endphp
                                <div class="flex flex-col items-center {{ $positions[$index] == 0 ? 'order-2' : ($positions[$index] == 1 ? 'order-1' : 'order-3') }}">
                                    <div class="text-4xl mb-2">{{ ['🥇', '🥈', '🥉'][$index] }}</div>
                                    <div class="bg-gradient-to-t {{ $colors['bg'] }} {{ $heights[$positions[$index]] }} w-24 rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-2">
                                        <div class="text-center">
                                            <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1">{{ $index + 1 }}.</div>
                                            <div class="text-xs font-semibold text-gray-800 truncate">{{ Str::limit($team->name, 10) }}</div>
                                            <div class="text-xs {{ $colors['text-points'] }} font-bold">{{ $team->score }}P</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Team Suche -->
                        <div class="mb-6">
                            <div class="relative">
                                <input type="text" id="team-search-input" placeholder="Team suchen..."
                                       class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Teams -->
                        <div id="team-search-results" class="space-y-2">
                            @if($teams->count() > 3)
                                @foreach($teams->slice(3) as $index => $team)
                                    @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-shadow">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-gray-700 text-sm">
                                                {{ $index + 4 }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">{{ $team->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $team->klasse->name ?? 'N/A' }} • {{ $team->klasse->school->name ?? '-' }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }}">{{ $team->score }}</div>
                                            <div class="text-xs text-gray-500">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Disziplinen Ranking -->
            @if(!empty($bestTeamsPerDiscipline))
                <div id="disciplines-section" class="ranking-section hidden">
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">🎯 Beste Teams pro Disziplin</h2>

                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($bestTeamsPerDiscipline as $best)
                                <div class="bg-gradient-to-br from-indigo-50 to-emerald-50 rounded-xl p-6 border border-indigo-200 hover:shadow-lg transition-shadow">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="text-2xl">🏅</div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-indigo-600">{{ $best['best_score'] }}</div>
                                            <div class="text-xs text-gray-500">Punkte</div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="text-sm font-medium text-gray-600">{{ $best['discipline_name'] ?? 'Disziplin ' . $best['discipline_id'] }}</div>
                                        <div class="text-lg font-bold text-gray-800">{{ $best['team_name'] ?? 'Team ' . $best['team_id'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
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

        // Team Search
        const teamSearchInput = document.getElementById('team-search-input');
        const teamSearchResults = document.getElementById('team-search-results');

        if (teamSearchInput && teamSearchResults) {
            teamSearchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();

                if (searchTerm === '') {
                    // Show original teams list
                    teamSearchResults.innerHTML = `
                        @if($teams->count() > 3)
                    @foreach($teams->slice(3) as $index => $team)
                    @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-shadow">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-gray-700 text-sm">
                                            {{ $index + 4 }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">{{ $team->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $team->klasse->name ?? 'N/A' }} • {{ $team->klasse->school->name ?? '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold {{ $colors['text-points'] }}">{{ $team->score }}</div>
                                        <div class="text-xs text-gray-500">Punkte</div>
                                    </div>
                                </div>
                            @endforeach
                    @endif
                    `;
                    return;
                }

                const filteredTeams = allTeamsData.filter(team =>
                    team.name.toLowerCase().includes(searchTerm) ||
                    team.klasse_name.toLowerCase().includes(searchTerm) ||
                    team.school_name.toLowerCase().includes(searchTerm)
                );

                if (filteredTeams.length === 0) {
                    teamSearchResults.innerHTML = '<p class="text-center text-gray-500 py-8">Keine Teams gefunden</p>';
                    return;
                }

                teamSearchResults.innerHTML = filteredTeams.map((team, index) => {
                    const colors = colorMap[team.school_id] || colorMap['default'] || {};
                    return `
                        <div class="flex items-center justify-between p-4 rounded-lg ${colors['bg-light'] || 'bg-gray-50'} border-l-4 ${colors['border-light'] || 'border-gray-300'} hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center font-bold text-gray-700 text-sm">
                                    ${index + 1}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">${team.name}</div>
                                    <div class="text-xs text-gray-500">${team.klasse_name} • ${team.school_name}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold ${colors['text-points'] || 'text-indigo-600'}">${team.score}</div>
                                <div class="text-xs text-gray-500">Punkte</div>
                            </div>
                        </div>
                    `;
                }).join('');
            });
        }
    </script>
</x-layout>
