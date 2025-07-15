<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-8">
        <div class="container mx-auto px-4">

            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">📋 Laufzettel</h1>
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

                    {{--suchergebnisse --}}
                    <div id="team-search-results" class="mt-4">

                    </div>
                </div>
            @else
                {{-- team info --}}
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="relative bg-white rounded-lg shadow-md p-6 {{ $schoolColors['bg-light'] ?? 'bg-blue-50' }}">

                        <!-- Bonus-Indikator in der oberen rechten Ecke -->
                        @if($selectedTeam->bonus)
                            <div class="absolute top-4 right-4">
                                <div class="bonus-indicator bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium cursor-pointer hover:bg-green-200 transition-all duration-200 shadow-sm border border-green-200"
                                     onclick="showBonusInfo(event)"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'"
                                     title="Klicken für mehr Informationen">
                                    ⭐ Bonus
                                </div>
                            </div>
                        @endif

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
                                @if($overallRanking)
                                    <p><strong>Platzierung:</strong>
                                        <span class="font-bold {{ $schoolColors['text-points'] ?? 'text-yellow-300' }}">
                                            {{ $overallRanking }}/{{ $totalTeams }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

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

                        <!-- wenn zu schmal (mobil)-->
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

                {{-- Der Button jetzt ganz unten --}}
                <div class="max-w-4xl mx-auto mt-8">
                    <a href="{{ route('laufzettel.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Anderes Team suchen
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if(isset($teamsForJs) && isset($colorMapForJs))
        <script>
            // Daten für JavaScript verfügbar machen
            const allTeamsData = @json($teamsForJs);
            const colorMap = @json($colorMapForJs);
            const isAdmin = @json($isAdmin ?? false);
        </script>
    @endif

    <!-- Bonus Info Popup Script -->
    <script>
        // Bonus Info Tooltip Funktionen
        function showBonusInfo(event) {
            event.stopPropagation();

            // Tooltip erstellen
            const tooltip = document.createElement('div');
            tooltip.id = 'bonus-tooltip';
            tooltip.className = 'fixed z-50 bg-white border border-gray-200 rounded-lg shadow-lg p-4 max-w-sm animate-fade-in';
            tooltip.style.animation = 'fadeIn 0.2s ease-out';
            tooltip.innerHTML = `
                <div class="flex items-start space-x-2">
                    <div class="text-green-600 text-xl">👕</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Bonus für passende Outfits</h4>
                        <p class="text-sm text-gray-600">
                            Dieses Team hat passende Outfits als Team getragen und erhält dafür Bonus-Punkte in der Gesamtwertung.
                        </p>
                    </div>
                </div>
                <div class="mt-2 pt-2 border-t border-gray-100">
                    <p class="text-xs text-gray-500">💡 Klicke irgendwo anders, um das Fenster zu schließen</p>
                </div>
            `;

            // Position berechnen
            const rect = event.target.getBoundingClientRect();
            const tooltipWidth = 280;
            const tooltipHeight = 120;

            let left = rect.left + window.scrollX;
            let top = rect.bottom + window.scrollY + 8;

            // Auf der linken Seite anzeigen, wenn rechts kein Platz
            if (left + tooltipWidth > window.innerWidth) {
                left = rect.left + window.scrollX - tooltipWidth - 8;
            }

            // Nach oben verschieben, wenn unten kein Platz
            if (top + tooltipHeight > window.innerHeight + window.scrollY) {
                top = rect.top + window.scrollY - tooltipHeight - 8;
            }

            // Mindestabstand zu den Rändern
            left = Math.max(10, Math.min(left, window.innerWidth - tooltipWidth - 10));
            top = Math.max(10, top);

            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';

            // Vorheriges Tooltip entfernen
            const existingTooltip = document.getElementById('bonus-tooltip');
            if (existingTooltip) {
                existingTooltip.remove();
            }

            document.body.appendChild(tooltip);

            // Debug-Ausgabe
            console.log('Bonus-Tooltip erstellt und positioniert');

            // Tooltip nach 8 Sekunden automatisch ausblenden
            setTimeout(() => {
                const currentTooltip = document.getElementById('bonus-tooltip');
                if (currentTooltip) {
                    currentTooltip.style.animation = 'fadeOut 0.2s ease-in';
                    setTimeout(() => {
                        if (currentTooltip.parentNode) {
                            currentTooltip.remove();
                        }
                    }, 200);
                }
            }, 8000);
        }

        function hideBonusInfo() {
            const tooltip = document.getElementById('bonus-tooltip');
            if (tooltip) {
                tooltip.style.animation = 'fadeOut 0.2s ease-in';
                setTimeout(() => {
                    if (tooltip.parentNode) {
                        tooltip.remove();
                    }
                }, 200);
            }
        }

        // Event Listener für Klicks außerhalb des Tooltips
        document.addEventListener('click', function(event) {
            const tooltip = document.getElementById('bonus-tooltip');
            if (tooltip && !tooltip.contains(event.target) && !event.target.closest('.bonus-indicator')) {
                hideBonusInfo();
            }
        });

        // ESC-Taste zum Schließen
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideBonusInfo();
            }
        });

        // CSS-Animationen hinzufügen
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(-10px); }
            }
        `;
        document.head.appendChild(style);

        // Test ob die Funktion geladen wurde
        console.log('Bonus Info Script geladen');
    </script>
</x-layout>
