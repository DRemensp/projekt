<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="min-h-screen bg-gradient-to-br from-blue-100 to-green-100 py-8 transition-colors duration-300 dark:bg-none">
        <div class="container mx-auto px-4">

            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mb-2 transition-colors duration-300">📋 Laufzettel</h1>
            </div>

            @if(!$selectedTeam)
                <!-- Team-Suche -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-colors duration-300">
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
            @else
                {{-- team info --}}
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 {{ $schoolColors['bg-light'] ?? 'bg-blue-50' }} transition-colors duration-300">

                        <!-- Mitglieder-Button in der oberen linken Ecke -->
                        @if($selectedTeam->members && ((is_array($selectedTeam->members) && count($selectedTeam->members) > 0) || (is_string($selectedTeam->members) && count(json_decode($selectedTeam->members, true)) > 0)))
                            <div class="absolute top-4 left-4">
                                <button class="members-btn bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-medium cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-800 transition-all duration-200 shadow-sm border border-blue-200 dark:border-blue-700"
                                        onclick="openMembersModal()"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'"
                                        title="Klicken für Mitglieder">
                                    👥 Mitglieder
                                </button>
                            </div>
                        @endif

                        <!-- Bonus-Button in der oberen rechten Ecke -->
                        @if($selectedTeam->bonus)
                            <div class="absolute top-4 right-4">
                                <button class="bonus-btn bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium cursor-pointer hover:bg-green-200 dark:hover:bg-green-800 transition-all duration-200 shadow-sm border border-green-200 dark:border-green-700"
                                        onclick="openBonusModal()"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'"
                                        title="Klicken für Bonus-Info">
                                    ⭐ Bonus
                                </button>
                            </div>
                        @endif

                        <div class="text-center">
                            <h2 class="text-3xl font-bold {{ $schoolColors['text'] ?? 'text-gray-800 dark:text-gray-100' }} mb-2 transition-colors duration-300">
                                {{ $selectedTeam->name }}
                            </h2>
                            <div class="text-lg text-gray-600 dark:text-gray-300 space-y-1 transition-colors duration-300">
                                <p><strong>Klasse:</strong> {{ $selectedTeam->klasse->name ?? 'N/A' }}</p>
                                <p><strong>Schule:</strong> {{ $selectedTeam->klasse->school->name ?? 'N/A' }}</p>
                                <p><strong>Gesamtpunkte:</strong>
                                    <span class="font-bold {{ $schoolColors['text-points'] ?? 'text-blue-600 dark:text-blue-400' }} transition-colors duration-300">
                                        {{ $selectedTeam->score }}
                                    </span>
                                </p>
                                @if($overallRanking)
                                    <p><strong>Platzierung:</strong>
                                        <span class="font-bold {{ $schoolColors['text-points'] ?? 'text-yellow-300 dark:text-yellow-400' }} transition-colors duration-300">
                                            {{ $overallRanking }}/{{ $totalTeams }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $scoreEntryUrl = route('dashboard', [
                        'scan_team' => $selectedTeam->id,
                        'open_score_modal' => 1,
                    ]);
                @endphp

                <div class="max-w-4xl mx-auto mb-8 text-center">
                    <button
                        type="button"
                        onclick="openQrModal()"
                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:from-blue-700 hover:to-indigo-700"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h2m10 0h2a2 2 0 012 2v2m0 8a2 2 0 01-2 2h-2m-10 0H5a2 2 0 01-2-2v-2m0-4h18"></path>
                        </svg>
                        QR-Code anzeigen
                    </button>
                </div>

                <div class="max-w-6xl mx-auto">
                    @if(empty($teamResults))
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 text-center transition-colors duration-300">
                            <p class="text-gray-500 dark:text-gray-400 text-lg transition-colors duration-300">Keine Disziplinen gefunden.</p>
                        </div>
                    @else
                        <!-- Desktop Tabelle -->
                        <div class="hidden md:block bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
                            <table class="min-w-full">
                                <thead class="bg-gray-100 dark:bg-gray-700 transition-colors duration-300">
                                <tr>
                                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                        Disziplin
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                        Platz
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                        Versuch 1
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                        Versuch 2
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                        Beste Leistung
                                    </th>
                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider transition-colors duration-300">
                                        🏆 Highscore
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition-colors duration-300">
                                @foreach($teamResults as $result)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                                        <td class="py-4 px-6">
                                            <div class="font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">{{ $result['discipline_name'] }}</div>
                                            @if($result['discipline_unit'])
                                                <div class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-300">Einheit: {{ $result['discipline_unit'] }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($result['has_participated'])
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transition-colors duration-300
                                                        @if($result['position'] <= 3)
                                                            bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                        @else
                                                            bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                                        @endif">
                                                        {{ $result['position'] }}/{{ $result['total_participants'] }}
                                                    </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 italic transition-colors duration-300">Nicht teilgenommen</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100 transition-colors duration-300">
                                            {{ $result['scores']['score_1'] ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center text-gray-900 dark:text-gray-100 transition-colors duration-300">
                                            {{ $result['scores']['score_2'] ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($result['has_participated'])
                                                <span class="font-semibold {{ $schoolColors['text-points'] ?? 'text-blue-600 dark:text-blue-400' }} transition-colors duration-300">
                                                        {{ $result['scores']['best_score'] }}
                                                    @if($result['discipline_unit'])
                                                        {{ $result['discipline_unit'] }}
                                                    @endif
                                                    </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 transition-colors duration-300">-</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            @if($result['highscore'] !== null)
                                                <span class="font-bold text-amber-600 dark:text-amber-400 transition-colors duration-300">
                                                        {{ $result['highscore'] }}
                                                    @if($result['discipline_unit'])
                                                        {{ $result['discipline_unit'] }}
                                                    @endif
                                                    </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500 transition-colors duration-300">-</span>
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
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 transition-colors duration-300">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 transition-colors duration-300">{{ $result['discipline_name'] }}</h3>
                                        @if($result['has_participated'])
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium transition-colors duration-300
                                                @if($result['position'] <= 3)
                                                    bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                @else
                                                    bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                                @endif">
                                                {{ $result['position'] }}/{{ $result['total_participants'] }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($result['has_participated'])
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Versuch 1:</span>
                                                <span class="ml-1 font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">{{ $result['scores']['score_1'] ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Versuch 2:</span>
                                                <span class="ml-1 font-medium text-gray-900 dark:text-gray-100 transition-colors duration-300">{{ $result['scores']['score_2'] ?? '-' }}</span>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Beste Leistung:</span>
                                                <span class="ml-1 font-semibold {{ $schoolColors['text-points'] ?? 'text-blue-600 dark:text-blue-400' }} transition-colors duration-300">
                                                    {{ $result['scores']['best_score'] }}
                                                    @if($result['discipline_unit'])
                                                        {{ $result['discipline_unit'] }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-500 dark:text-gray-400 transition-colors duration-300">🏆 Highscore:</span>
                                                @if($result['highscore'] !== null)
                                                    <span class="ml-1 font-bold text-amber-600 dark:text-amber-400 transition-colors duration-300">
                                                        {{ $result['highscore'] }}
                                                        @if($result['discipline_unit'])
                                                            {{ $result['discipline_unit'] }}
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="ml-1 text-gray-400 dark:text-gray-500 transition-colors duration-300">-</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-gray-400 dark:text-gray-500 italic text-sm transition-colors duration-300">Nicht teilgenommen</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Der Button jetzt ganz unten --}}
                <div class="max-w-4xl mx-auto mt-8">
                    <a href="{{ route('laufzettel.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Anderes Team suchen
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- QR Modal -->
    <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 z-50 hidden transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full transition-colors duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-300">QR-Code für Stationen</h3>
                        <button onclick="closeModal('qrModal')" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-300">
                        Station scannt diesen Code, Team wird im Klassen-Dashboard direkt vorausgewählt und das Score-Popup öffnet sich.
                    </p>
                    <div class="mt-4 flex justify-center">
                        <div class="rounded-lg border border-gray-200 bg-white p-3 shadow dark:border-gray-700">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(260)->margin(1)->generate($scoreEntryUrl) !!}
                        </div>
                    </div>
                    <p class="mt-3 text-center text-xs text-gray-500 dark:text-gray-400 break-all">
                        Ziel: {{ $scoreEntryUrl }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mitglieder Modal -->
    <div id="membersModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 z-50 hidden transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full transition-colors duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-300">👥 Mitglieder</h3>
                        <button onclick="closeModal('membersModal')" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="membersContent" class="space-y-2">
                        <!-- Wird von JavaScript gefüllt -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bonus Modal -->
    <div id="bonusModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 z-50 hidden transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full transition-colors duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 transition-colors duration-300">⭐ Bonus</h3>
                        <button onclick="closeModal('bonusModal')" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="text-green-600 dark:text-green-400 text-2xl transition-colors duration-300">👕</div>
                        <div>
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2 transition-colors duration-300">Bonus für passende Outfits</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors duration-300">
                                Dieses Team hat passende Outfits als Team getragen und erhält dafür Bonus-Punkte in der Gesamtwertung.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($teamsForJs) && isset($colorMapForJs))
        <script>
            // Daten für JavaScript verfügbar machen
            const allTeamsData = @json($teamsForJs);
            const colorMap = @json($colorMapForJs);
            const isAdmin = @json($isAdmin ?? false);
            const teamMembers = @json($selectedTeam->members ?? null);
        </script>
    @endif

    <script>
        function openQrModal() {
            document.getElementById('qrModal').classList.remove('hidden');
        }

        function openMembersModal() {
            // Teammitglieder parsen - berücksichtigt sowohl Array als auch JSON-String
            let membersData = null;

            if (Array.isArray(teamMembers)) {
                membersData = teamMembers;
            } else if (typeof teamMembers === 'string') {
                try {
                    membersData = JSON.parse(teamMembers);
                } catch (e) {
                    membersData = null;
                }
            }

            const content = document.getElementById('membersContent');

            if (!membersData || !Array.isArray(membersData) || membersData.length === 0) {
                content.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-sm transition-colors duration-300">Keine Mitglieder gefunden.</p>';
            } else {
                let html = '';
                membersData.forEach(member => {
                    html += `
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-700 rounded transition-colors duration-300">
                            <div class="w-2 h-2 bg-blue-500 dark:bg-blue-400 rounded-full transition-colors duration-300"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-200 transition-colors duration-300">${member}</span>
                        </div>
                    `;
                });
                content.innerHTML = html;
            }

            document.getElementById('membersModal').classList.remove('hidden');
        }

        function openBonusModal() {
            document.getElementById('bonusModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

    </script>
</x-layout>
