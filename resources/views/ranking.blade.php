@php use App\Services\SchoolColorService; @endphp
<x-layout>
    <x-slot:heading>Live Rangliste</x-slot:heading>


    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 dark:from-gray-900 dark:to-gray-800 py-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="text-center mb-12">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-5 mb-8 transition-colors duration-300">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-emerald-600 dark:from-indigo-400 dark:to-emerald-400 bg-clip-text text-transparent mb-4">
                        Live Rangliste
                    </h1>
                    <div class="max-w-3xl mx-auto bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 p-4 rounded-lg flex items-start space-x-3 transition-colors duration-300">
                        <svg class="h-6 w-6 text-blue-500 dark:text-blue-400 mt-0.5 flex-shrink-0 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                        </svg>
                        <div class="text-sm text-blue-800 dark:text-blue-200 text-left transition-colors duration-300">
                            <p class="font-semibold mb-1">Wie werden die Punkte berechnet?</p>
                            <ul class="list-disc ml-4 space-y-1 text-blue-700 dark:text-blue-300 transition-colors duration-300">
                                <li><strong>Teams:</strong> Erhalten Punkte basierend auf ihrer Platzierung in jeder Disziplin.</li>
                                <li><strong>Klassen & Schulen:</strong> Der Gesamtscore ergibt sich aus dem Durchschnitt der Punkte aller zugehörigen Teams.</li>
                                <li><strong>psstt:</strong> kleiner Tipp, Jede Schule besitzt ihre eigene Farbe!</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="flex justify-center mb-8 ">
                <nav class="bg-white dark:bg-gray-800 rounded-full shadow-lg p-1 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                    <div class="flex space-x-0.5">
                        <button onclick="showSection('schools')" class="ranking-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 bg-indigo-600 dark:bg-indigo-500 text-white">
                            Schulen
                        </button>
                        <button onclick="showSection('klasses')" class="ranking-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Klassen
                        </button>
                        <button onclick="showSection('teams')" class="ranking-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Teams
                        </button>
                        <button onclick="showSection('disciplines')" class="ranking-tab px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Disziplinen
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Schulen Ranking -->
            @if($schools->count() > 0)
                <div id="schools-section" class="ranking-section">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8 transition-colors duration-300">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">🏫 Schulen Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center mb-12">
                            <div class="flex items-end space-x-4" style="height: 208px;">
                                <!-- 2. Platz (Links) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($schools[1]))
                                        @php $colors = SchoolColorService::getColorClasses($schools[1]->id); @endphp
                                        <div class="text-4xl mb-3">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 128px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $schools[1]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $schools[1]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 1. Platz (Mitte) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($schools[0]))
                                        @php $colors = SchoolColorService::getColorClasses($schools[0]->id); @endphp
                                        <div class="text-4xl mb-3">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 160px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $schools[0]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $schools[0]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. Platz (Rechts) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($schools[2]))
                                        @php $colors = SchoolColorService::getColorClasses($schools[2]->id); @endphp
                                        <div class="text-4xl mb-3">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 112px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $schools[2]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $schools[2]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Schulen -->
                        @if($schools->count() > 3)
                            <div class="space-y-3">
                                @foreach($schools->slice(3) as $index => $school)
                                    @php $colors = SchoolColorService::getColorClasses($school->id); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center font-bold text-gray-700 dark:text-gray-200 text-sm transition-colors duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                            <span class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $school->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $school->score }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Punkte</div>
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
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8 transition-colors duration-300">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">👥 Klassen Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center mb-12">
                            <div class="flex items-end space-x-4" style="height: 208px;">
                                <!-- 2. Platz (Links) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($klasses[1]))
                                        @php $colors = SchoolColorService::getColorClasses($klasses[1]->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 128px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $klasses[1]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $klasses[1]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 1. Platz (Mitte) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($klasses[0]))
                                        @php $colors = SchoolColorService::getColorClasses($klasses[0]->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 160px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $klasses[0]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $klasses[0]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. Platz (Rechts) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($klasses[2]))
                                        @php $colors = SchoolColorService::getColorClasses($klasses[2]->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 112px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $klasses[2]->name }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $klasses[2]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Klassen -->
                        @if($klasses->count() > 3)
                            <div class="space-y-3">
                                @foreach($klasses->slice(3) as $index => $klasse)
                                    @php $colors = SchoolColorService::getColorClasses($klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center font-bold text-gray-700 dark:text-gray-200 text-sm transition-colors duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                            <span class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $klasse->name }}</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $klasse->score }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Punkte</div>
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
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 mb-8 transition-colors duration-300">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">🏆 Teams Rangliste</h2>

                        <!-- Podium für Top 3 -->
                        <div class="flex justify-center mb-12">
                            <div class="flex items-end space-x-4" style="height: 208px;">
                                <!-- 2. Platz (Links) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($teams[1]))
                                        @php $colors = SchoolColorService::getColorClasses($teams[1]->klasse->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥈</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 128px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">2.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $teams[1]->name }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 break-words leading-tight transition-colors duration-300">{{ $teams[1]->klasse->name ?? 'N/A' }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $teams[1]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 1. Platz (Mitte) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($teams[0]))
                                        @php $colors = SchoolColorService::getColorClasses($teams[0]->klasse->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥇</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 160px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">1.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $teams[0]->name }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 break-words leading-tight transition-colors duration-300">{{ $teams[0]->klasse->name ?? 'N/A' }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $teams[0]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- 3. Platz (Rechts) -->
                                <div class="flex flex-col items-center" style="width: 96px;">
                                    @if(isset($teams[2]))
                                        @php $colors = SchoolColorService::getColorClasses($teams[2]->klasse->school_id ?? 0); @endphp
                                        <div class="text-4xl mb-3">🥉</div>
                                        <div class="bg-gradient-to-t {{ $colors['bg'] }} rounded-t-lg border-4 {{ $colors['border'] }} flex flex-col justify-end p-3 shadow-lg" style="height: 112px; width: 96px;">
                                            <div class="text-center">
                                                <div class="text-xs font-bold {{ $colors['text-subtle'] }} mb-1 transition-colors duration-300">3.</div>
                                                <div class="text-xs font-semibold text-gray-800 dark:text-gray-200 break-words leading-tight transition-colors duration-300">{{ $teams[2]->name }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 break-words leading-tight transition-colors duration-300">{{ $teams[2]->klasse->name ?? 'N/A' }}</div>
                                                <div class="text-xs {{ $colors['text-points'] }} font-bold mt-1 transition-colors duration-300">{{ $teams[2]->score }}P</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Weitere Teams -->
                        @if($teams->count() > 3)
                            <div class="space-y-3">
                                @foreach($teams->slice(3) as $index => $team)
                                    @php $colors = SchoolColorService::getColorClasses($team->klasse->school_id ?? 0); @endphp
                                    <div class="flex items-center justify-between p-4 rounded-lg {{ $colors['bg-light'] }} border-l-4 {{ $colors['border-light'] }} hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-8 h-8 bg-white dark:bg-gray-700 rounded-full flex items-center justify-center font-bold text-gray-700 dark:text-gray-200 text-sm transition-colors duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200 transition-colors duration-300">{{ $team->name }}</span>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">{{ $team->klasse->name ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $team->score }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 transition-colors duration-300">Punkte</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Team-Suche -->
                        <div class="max-w-2xl mx-auto mt-12">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border-2 border-gray-300 dark:border-gray-700 transition-colors duration-300">
                                <label for="team-search-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors duration-300">
                                    Team suchen:
                                </label>
                                <input type="text"
                                       id="team-search-input"
                                       placeholder="Teamname eingeben..."
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-300">
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
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transition-colors duration-300">
                        <h2 class="text-2xl font-bold text-center mb-8 text-gray-800 dark:text-gray-100 transition-colors duration-300">🎯 Beste Teams pro Disziplin</h2>

                        <div class="space-y-4">
                            @foreach($bestTeamsPerDiscipline as $champion)
                                @php $colors = SchoolColorService::getColorClasses($champion['team_school_id'] ?? 0); @endphp
                                <div onclick="openDisciplineModal({{ $champion['discipline_id'] }})" class="group relative overflow-hidden rounded-xl bg-gradient-to-r {{ $colors['gradient'] }} border {{ $colors['border-light'] }} hover:shadow-xl transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                                    <div class="absolute top-4 right-4 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>

                                    <div class="p-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-1 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors duration-300">
                                                    {{ $champion['discipline_name'] ?? 'Disziplin ' . $champion['discipline_id'] }}
                                                </h3>
                                                <p class="text-lg font-semibold {{ $colors['text'] }} mb-2 transition-colors duration-300">
                                                    Team: {{ $champion['team_name'] ?? 'Team ' . $champion['team_id'] }}
                                                </p>
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4 {{ $colors['text-subtle'] }} transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                    <span class="text-lg font-bold {{ $colors['text-points'] }} transition-colors duration-300">{{ $champion['best_score'] }}</span>
                                                    <span class="text-2xl">🏆</span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">Bestleistung</span>
                                                </div>
                                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-300 transition-colors duration-300">
                                                    → Klicken für Details und vollständige Rangliste
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

    <!-- Modal für Disziplin-Details -->
    <div id="disciplineModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 hidden items-center justify-center z-50 transition-all duration-300" onclick="closeDisciplineModal(event)">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden transition-colors duration-300" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-700 dark:to-indigo-700 px-6 py-4 flex justify-between items-center transition-colors duration-300">
                <h3 id="modalTitle" class="text-2xl font-bold text-white"></h3>
                <button onclick="closeDisciplineModal()" class="text-white hover:text-gray-200 dark:hover:text-gray-300 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>

    <!-- JavaScript für Tab-Navigation und externe Suchfunktionalität -->
    <script>
        // Daten für laufzettel-search.js bereitstellen
        const allTeamsData = @json($teamsForJs ?? []);
        const colorMap = @json($colorMapForJs ?? ['default' => []]);
        const disciplineDetails = @json($disciplineDetailsForJs ?? []);

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

        // Modal Funktionen
        function openDisciplineModal(disciplineId) {
            const discipline = disciplineDetails[disciplineId];
            if (!discipline) return;

            const modal = document.getElementById('disciplineModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');

            modalTitle.textContent = discipline.name;

            // Simpel: Liste der Teams mit Platz und Score
            let html = '<div class="space-y-3">';

            if (discipline.teams.length === 0) {
                html += '<p class="text-gray-600 dark:text-gray-400 text-center py-8 transition-colors duration-300">Keine Teams haben an dieser Disziplin teilgenommen.</p>';
            } else {
                discipline.teams.forEach(team => {
                    const colors = getColorForSchool(team.school_id);
                    const medal = team.rank === 1 ? '🥇' : team.rank === 2 ? '🥈' : team.rank === 3 ? '🥉' : '';

                    html += `
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r ${colors.bgLight} border-l-4 ${colors.borderLight} rounded-lg hover:shadow-md transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-10 h-10 ${medal ? '' : 'bg-white dark:bg-gray-700 rounded-full transition-colors duration-300'}">
                                    ${medal ? `<span class="text-2xl">${medal}</span>` : `<span class="font-bold text-gray-700 dark:text-gray-200 text-lg transition-colors duration-300">${team.rank}</span>`}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-300">${team.team_name}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">${team.klasse_name}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold ${colors.textPoints} transition-colors duration-300">${team.best_score}</div>
                            </div>
                        </div>
                    `;
                });
            }

            html += '</div>';
            modalContent.innerHTML = html;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDisciplineModal(event) {
            if (event && event.target !== event.currentTarget) return;
            const modal = document.getElementById('disciplineModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function getColorForSchool(schoolId) {
            const colors = colorMap[schoolId] || colorMap['default'];
            return {
                bgLight: colors['bg-light'] || 'from-gray-50 to-gray-100',
                borderLight: colors['border-light'] || 'border-gray-300',
                textPoints: colors['text-points'] || 'text-gray-700'
            };
        }
    </script>

    <!-- Import der laufzettel-search.js für Suchfunktionalität -->
    @vite(['resources/js/laufzettel-search.js'])
</x-layout>
