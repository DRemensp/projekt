<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="container mx-auto px-4">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">📋 Laufzettel</h1>
                <p class="text-lg text-gray-600">Suche nach einem Team, um dessen Ergebnisse zu sehen</p>
            </div>

            @if(!$selectedTeam)
                <!-- Team-Suche -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <label for="team-search-input" class="block text-sm font-medium text-gray-700 mb-2">
                            Team suchen:
                        </label>
                        <input type="text"
                               id="team-search-input"
                               placeholder="Teamname eingeben..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Suchergebnisse -->
                    <div id="team-search-results" class="mt-4">
                        <!-- Wird durch JavaScript gefüllt -->
                    </div>
                </div>
            @else
                <!-- Zurück-Button -->
                <div class="max-w-4xl mx-auto mb-6">
                    <a href="{{ route('laufzettel.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Anderes Team suchen
                    </a>
                </div>

                <!-- Team-Info -->
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6 {{ $schoolColors['bg-light'] ?? 'bg-blue-50' }}">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold {{ $schoolColors['text'] ?? 'text-gray-800' }} mb-2">
                                {{ $selectedTeam->name }}
                            </h2>
                            <div class="text-lg text-gray-600 space-y-1">
                                <p><strong>Klasse:</strong> {{ $selectedTeam->klasse->name ?? 'N/A' }}</p>
                                <p><strong>Schule:</strong> {{ $selectedTeam->klasse->school->name ?? 'N/A' }}</p>
                                <p><strong>Gesamtpunkte:</strong>
                                    <span class="font-bold {{ $schoolColors['text-points'] ?? 'text-blue-600' }}">
                                        {{ $selectedTeam->score }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ergebnisse -->
                <div class="max-w-6xl mx-auto">
                    @if(empty($teamResults))
                        <div class="bg-white rounded-lg shadow-md p-8 text-center">
                            <p class="text-gray-500 text-lg">Keine Disziplinen gefunden.</p>
                        </div>
                    @else
                        <!-- Desktop Tabelle -->
                        <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                        Disziplin
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                        Platz
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                        Versuch 1
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                        Versuch 2
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                        Beste Leistung
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                        🏆 Highscore
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach($teamResults as $result)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-6">
                                            <div class="font-medium text-gray-900">{{ $result['discipline_name'] }}</div>
                                            @if($result['discipline_unit'])
                                                <div class="text-sm text-gray-500">Einheit: {{ $result['discipline_unit'] }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($result['has_participated'])
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                        @if($result['position'] <= 3)
                                                            bg-yellow-100 text-yellow-800
                                                        @else
                                                            bg-gray-100 text-gray-800
                                                        @endif">
                                                        {{ $result['position'] }}/{{ $result['total_participants'] }}
                                                    </span>
                                            @else
                                                <span class="text-gray-400 italic">Nicht teilgenommen</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            {{ $result['scores']['score_1'] ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            {{ $result['scores']['score_2'] ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($result['has_participated'])
                                                <span class="font-semibold {{ $schoolColors['text-points'] ?? 'text-blue-600' }}">
                                                        {{ $result['scores']['best_score'] }}
                                                    @if($result['discipline_unit'])
                                                        {{ $result['discipline_unit'] }}
                                                    @endif
                                                    </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($result['highscore'] !== null)
                                                <span class="font-bold text-amber-600">
                                                        {{ $result['highscore'] }}
                                                    @if($result['discipline_unit'])
                                                        {{ $result['discipline_unit'] }}
                                                    @endif
                                                    </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Cards -->
                        <div class="md:hidden space-y-4">
                            @foreach($teamResults as $result)
                                <div class="bg-white rounded-lg shadow-md p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="font-semibold text-lg text-gray-900">{{ $result['discipline_name'] }}</h3>
                                        @if($result['has_participated'])
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($result['position'] <= 3)
                                                    bg-yellow-100 text-yellow-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $result['position'] }}/{{ $result['total_participants'] }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($result['has_participated'])
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500">Versuch 1:</span>
                                                <span class="ml-1 font-medium">{{ $result['scores']['score_1'] ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Versuch 2:</span>
                                                <span class="ml-1 font-medium">{{ $result['scores']['score_2'] ?? '-' }}</span>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-500">Beste Leistung:</span>
                                                <span class="ml-1 font-semibold {{ $schoolColors['text-points'] ?? 'text-blue-600' }}">
                                                    {{ $result['scores']['best_score'] }}
                                                    @if($result['discipline_unit'])
                                                        {{ $result['discipline_unit'] }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-500">🏆 Highscore:</span>
                                                @if($result['highscore'] !== null)
                                                    <span class="ml-1 font-bold text-amber-600">
                                                        {{ $result['highscore'] }}
                                                        @if($result['discipline_unit'])
                                                            {{ $result['discipline_unit'] }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="ml-1 text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-400 italic text-sm">Nicht teilgenommen</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if(isset($teamsForJs) && isset($colorMapForJs))
        <script>
            // Daten für JavaScript verfügbar machen
            const allTeamsData = @json($teamsForJs);
            const colorMap = @json($colorMapForJs);
        </script>
    @endif
</x-layout>
