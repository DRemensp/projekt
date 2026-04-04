<x-layout>
    <x-slot:heading>
        📚 {{ $archive->name }}
    </x-slot:heading>

    <div class="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen transition-colors duration-200 dark:bg-none">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Header -->
            <div class="bg-white night-panel dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <h1 class="display-font text-2xl font-bold bg-gradient-to-r from-indigo-600 to-emerald-600 dark:from-teal-300 dark:to-sky-300 bg-clip-text text-transparent mb-2 sm:mb-0">
                        {{ $archive->name }}
                    </h1>
                    <span class="bg-gradient-to-r from-blue-50 to-green-50 dark:from-slate-900/70 dark:to-slate-900/40 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-full text-sm font-medium shadow-sm border border-gray-200 dark:border-slate-600/60 transition-colors duration-200">
                         {{ $archive->archived_date->format('d.m.Y') }}
                    </span>
                </div>

                @if($archive->description)
                    <div class="mb-4 p-3 bg-blue-50 dark:bg-slate-900/70 border border-blue-200 dark:border-sky-400/40 rounded-lg transition-colors duration-200">
                        <p class="text-gray-700 dark:text-gray-200 text-sm leading-relaxed transition-colors duration-200">{{ $archive->description }}</p>
                    </div>
                @endif

                <!-- Statistik Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-500/18 dark:to-blue-400/6 p-4 rounded-lg text-center border border-blue-200 dark:border-blue-400/40 hover:shadow-md transition-all duration-200">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-300 mb-1 transition-colors duration-200">{{ $archive->data['total_schools'] ?? 0 }}</div>
                        <div class="text-xs font-medium text-blue-700 dark:text-blue-200 transition-colors duration-200">🏫 Schulen</div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-500/18 dark:to-green-400/6 p-4 rounded-lg text-center border border-green-200 dark:border-green-400/40 hover:shadow-md transition-all duration-200">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-300 mb-1 transition-colors duration-200">{{ $archive->data['total_klasses'] ?? 0 }}</div>
                        <div class="text-xs font-medium text-green-700 dark:text-green-200 transition-colors duration-200">📚 Klassen</div>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-500/18 dark:to-orange-400/6 p-4 rounded-lg text-center border border-orange-200 dark:border-orange-400/40 hover:shadow-md transition-all duration-200">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-300 mb-1 transition-colors duration-200">{{ $archive->data['total_teams'] ?? 0 }}</div>
                        <div class="text-xs font-medium text-orange-700 dark:text-orange-200 transition-colors duration-200">👥 Teams</div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-500/18 dark:to-purple-400/6 p-4 rounded-lg text-center border border-purple-200 dark:border-purple-400/40 hover:shadow-md transition-all duration-200">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-300 mb-1 transition-colors duration-200">{{ $archive->data['total_students'] ?? 0 }}</div>
                        <div class="text-xs font-medium text-purple-700 dark:text-purple-200 transition-colors duration-200">👤 Schüler</div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex justify-center mb-6">
                <nav class="bg-white night-card dark:bg-gray-800 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex space-x-0.5">
                        <button class="tab-button active night-tab night-tab-active px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 dark:bg-indigo-500 text-white" data-tab="schools">
                            🏫 Schulen
                        </button>
                        <button class="tab-button night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800/70" data-tab="klasses">
                            📚 Klassen
                        </button>
                        <button class="tab-button night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800/70" data-tab="teams">
                            👥 Teams
                        </button>
                        <button class="tab-button night-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800/70" data-tab="disciplines">
                            🏆 Disziplinen
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Content Container -->
            <div class="bg-white night-panel dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-200">

                <!-- Schulen Ranking -->
                <div id="schools-tab" class="tab-content p-6">
                    <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-indigo-500 dark:border-indigo-400 pb-3 transition-colors duration-200">
                        🏫 Schulen Rangliste
                    </h3>
                    <div class="space-y-3">
                        @foreach($archive->data['school_ranking'] ?? [] as $school)
                            @php
                                $rankColors = match($school['rank']) {
                                   1 => ['bg' => 'from-yellow-400 to-yellow-500 dark:from-amber-400/70 dark:to-yellow-300/30', 'text' => 'text-yellow-800 dark:text-yellow-100'],
                                    2 => ['bg' => 'from-gray-300 to-gray-400 dark:from-slate-500/60 dark:to-slate-400/30', 'text' => 'text-gray-800 dark:text-slate-100'],
                                    3 => ['bg' => 'from-amber-600 to-amber-700 dark:from-amber-500/70 dark:to-orange-400/30', 'text' => 'text-amber-100 dark:text-amber-100'],
                                    default => ['bg' => 'from-indigo-400 to-indigo-500 dark:from-sky-500/60 dark:to-indigo-400/30', 'text' => 'text-white']
                                };
                                $cardBg = $school['rank'] <= 3 ? 'from-gray-50 to-yellow-50 dark:from-slate-900/70 dark:to-amber-500/12' : 'from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10';
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $cardBg }} rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-r border border-gray-400 dark:border-gray-500 {{ $rankColors['bg'] }} {{ $rankColors['text'] }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ $school['rank'] }}
                                    </div>
                                    <div>
                                        <span class="font-semibold text-base text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $school['name'] }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $school['score'] }}</div>
                                    <div class="text-xs text-gray-700 dark:text-gray-300 transition-colors duration-200">Punkte</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Klassen Ranking -->
                <div id="klasses-tab" class="tab-content p-6 hidden">
                    <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-green-500 dark:border-green-400 pb-3 transition-colors duration-200">
                        📚 Klassen Rangliste
                    </h3>
                    <div class="space-y-3">
                        @foreach($archive->data['klasse_ranking'] ?? [] as $klasse)
                            @php
                                $rankColors = match($klasse['rank']) {
                                    1 => ['bg' => 'from-yellow-400 to-yellow-500 dark:from-amber-400/70 dark:to-yellow-300/30', 'text' => 'text-yellow-800 dark:text-yellow-100'],
                                    2 => ['bg' => 'from-gray-300 to-gray-400 dark:from-slate-500/60 dark:to-slate-400/30', 'text' => 'text-gray-800 dark:text-slate-100'],
                                    3 => ['bg' => 'from-amber-600 to-amber-700 dark:from-amber-500/70 dark:to-orange-400/30', 'text' => 'text-amber-100 dark:text-amber-100'],
                                    default => ['bg' => 'from-indigo-400 to-indigo-500 dark:from-sky-500/60 dark:to-indigo-400/30', 'text' => 'text-white']
                                };
                                $cardBg = $klasse['rank'] <= 3 ? 'from-gray-50 to-yellow-50 dark:from-slate-900/70 dark:to-amber-500/12' : 'from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10';
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $cardBg }} rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-r border border-gray-400 dark:border-gray-500 {{ $rankColors['bg'] }} {{ $rankColors['text'] }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ $klasse['rank'] }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-base text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $klasse['name'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">{{ $klasse['school_name'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $klasse['score'] }}</div>
                                    <div class="text-xs text-gray-700 dark:text-gray-300 transition-colors duration-200">Punkte</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Teams Ranking -->
                <div id="teams-tab" class="tab-content p-6 hidden">
                    <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-orange-500 dark:border-orange-400 pb-3 transition-colors duration-200">
                        👥 Teams Rangliste (Top 20)
                    </h3>
                    <div class="space-y-3">
                        @foreach(collect($archive->data['team_ranking'] ?? [])->take(20) as $team)
                            @php
                                $rankColors = match($team['rank']) {
                                    1 => ['bg' => 'from-yellow-400 to-yellow-500 dark:from-amber-400/70 dark:to-yellow-300/30', 'text' => 'text-yellow-800 dark:text-yellow-100'],
                                    2 => ['bg' => 'from-gray-300 to-gray-400 dark:from-slate-500/60 dark:to-slate-400/30', 'text' => 'text-gray-800 dark:text-slate-100'],
                                    3 => ['bg' => 'from-amber-600 to-amber-700 dark:from-amber-500/70 dark:to-orange-400/30', 'text' => 'text-amber-100 dark:text-amber-100'],
                                    default => ['bg' => 'from-indigo-400 to-indigo-500 dark:from-sky-500/60 dark:to-indigo-400/30', 'text' => 'text-white']
                                };
                                $cardBg = $team['rank'] <= 3 ? 'from-gray-50 to-yellow-50 dark:from-slate-900/70 dark:to-amber-500/12' : 'from-gray-50 to-indigo-50 dark:from-slate-900/70 dark:to-sky-500/10';
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $cardBg }} rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gradient-to-r border border-gray-400 dark:border-gray-500 {{ $rankColors['bg'] }} {{ $rankColors['text'] }} rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                        {{ $team['rank'] }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-base text-gray-800 dark:text-gray-100 transition-colors duration-200">{{ $team['name'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">{{ $team['klasse_name'] }} - {{ $team['school_name'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-200">{{ $team['score'] }}</div>
                                    <div class="text-xs text-gray-700 dark:text-gray-300 transition-colors duration-200">Punkte</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Disziplinen Übersicht -->
                <div id="disciplines-tab" class="tab-content p-6 hidden">
                    <h3 class="display-font text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-100 border-b-2 border-blue-400 pb-3 transition-colors duration-200">
                        🏆 Beste Teams pro Disziplin
                    </h3>
                    @if(isset($archive->data['best_teams_per_discipline']) && count($archive->data['best_teams_per_discipline']) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($archive->data['best_teams_per_discipline'] as $discipline)
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-500/18 dark:to-blue-400/6 p-4 rounded-lg border border-purple-200 dark:border-purple-400/40 hover:shadow-md transition-all duration-200">
                                    <h4 class="font-semibold text-base text-gray-800 dark:text-gray-100 mb-2 transition-colors duration-200">{{ $discipline['discipline_name'] }}</h4>


                                    <div class="text-xs text-purple-600 dark:text-purple-300 mb-3 transition-colors duration-200">
                                        @if($discipline['higher_is_better'])
                                            📈 Höher ist besser
                                        @else
                                            📉 Niedriger ist besser
                                        @endif
                                    </div>

                                    <div class="pt-2 border-t border-purple-200 dark:border-purple-700 transition-colors duration-200">
                                        <div class="font-bold text-sm text-yellow-700 dark:text-amber-200 mb-1 transition-colors duration-200">🥇 Beste Leistung: {{ $discipline['best_score'] }}</div>

                                        <div class="text-purple-700 dark:text-purple-200 font-bold transition-colors duration-200">TEAM: {{ $discipline['team_name'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">{{ $discipline['klasse_name'] }} - {{ $discipline['school_name'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 transition-colors duration-200">Keine Disziplinen-Daten verfügbar.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-indigo-600', 'dark:bg-indigo-500', 'text-white', 'night-tab-active');
                        btn.classList.add('text-gray-600', 'dark:text-gray-300');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-indigo-600', 'dark:bg-indigo-500', 'text-white', 'night-tab-active');
                    this.classList.remove('text-gray-600', 'dark:text-gray-300');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show target tab content
                    document.getElementById(targetTab + '-tab').classList.remove('hidden');
                });
            });
        });
    </script>
</x-layout>
