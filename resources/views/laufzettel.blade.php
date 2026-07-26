<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.lp-theme')

    {{-- ===================== LIGHT MODE – „Sportfest-Poster“ ===================== --}}
    <div class="light-mode-only -mt-10">
        <section class="lp-sec-paper relative overflow-hidden pt-16 md:pt-28 pb-20 min-h-screen">
            <div class="lp-lanes absolute inset-0 pointer-events-none" aria-hidden="true"></div>

            <div class="container mx-auto px-4 relative z-10 max-w-4xl">

                @if(!$selectedTeam)
                    {{-- ===== Suche ===== --}}
                    <div class="text-center max-w-2xl mx-auto">
                        <div class="flex justify-center">
                            <span class="lp-kicker lp-reveal">Team-Steckbrief</span>
                        </div>
                        <h1 class="lp-display lp-h2 mt-4 lp-reveal lp-d1">
                            Der <span class="lp-outline">Laufzettel</span>
                        </h1>
                        <p class="lp-muted mt-4 lp-reveal lp-d2">
                            Such dein Team und sieh alle Disziplinen, Versuche, Bestwerte
                            und die aktuelle Platzierung auf einen Blick.
                        </p>
                    </div>

                    <div class="max-w-xl mx-auto mt-10 lp-reveal lp-d3">
                        <div class="lp-card lp-shadow p-5 -rotate-1">
                            <label for="lp-team-search" class="lp-display text-lg block">Team suchen</label>
                            <input type="text"
                                   id="lp-team-search"
                                   placeholder="Teamname eingeben …"
                                   autocomplete="off"
                                   class="w-full mt-3 px-4 py-3 rounded-xl border-2 lp-bord bg-white text-base font-semibold placeholder:font-normal placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[color:var(--lp-accent)]">
                            <div class="lp-barcode mt-5"></div>
                        </div>
                        <div id="lp-laufzettel-results" class="mt-6 space-y-3"></div>
                    </div>
                @else
                    {{-- ===== Team-Detail ===== --}}
                    @php
                        $scoreEntryUrl = route('dashboard', [
                            'scan_team' => $selectedTeam->id,
                            'open_score_modal' => 1,
                        ]);
                        $lpHasMembers = $selectedTeam->members
                            && ((is_array($selectedTeam->members) && count($selectedTeam->members) > 0)
                                || (is_string($selectedTeam->members) && count(json_decode($selectedTeam->members, true) ?? []) > 0));
                    @endphp

                    <div class="flex justify-center">
                        <span class="lp-kicker lp-reveal">Laufzettel</span>
                    </div>

                    {{-- Startnummern-Karte des Teams --}}
                    <div class="max-w-md mx-auto mt-6 lp-reveal lp-d1">
                        <div class="lp-card lp-shadow relative px-7 pt-7 pb-8 -rotate-1">
                            <span class="lp-pin absolute top-3 left-3"></span>
                            <span class="lp-pin absolute top-3 right-3"></span>
                            <span class="lp-pin absolute bottom-3 left-3"></span>
                            <span class="lp-pin absolute bottom-3 right-3"></span>

                            <div class="flex items-center justify-between text-[0.62rem] font-extrabold uppercase tracking-[0.22em] lp-muted">
                                <span>Campus Olympiade</span>
                                <span>Nr. {{ str_pad($selectedTeam->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="mt-3 border-t-2 border-dashed lp-bord opacity-20"></div>

                            <h1 class="lp-display text-3xl md:text-4xl text-center mt-5 break-words">{{ $selectedTeam->name }}</h1>
                            <p class="lp-muted text-center text-[0.68rem] font-bold uppercase tracking-[0.18em] mt-2 break-words">
                                <span class="inline-block w-2.5 h-2.5 rounded-full {{ $schoolColors['dot'] ?? 'bg-gray-400' }} border border-black/30 align-middle mr-1"></span>{{ $selectedTeam->klasse->name ?? 'N/A' }} · {{ $selectedTeam->klasse->school->name ?? 'N/A' }}
                            </p>

                            <div class="grid grid-cols-2 gap-px border-2 lp-bord rounded-xl overflow-hidden mt-6" style="background: rgba(22,29,39,0.5);">
                                <div class="bg-white px-3 py-4 text-center">
                                    <p class="lp-display text-3xl leading-none">{{ $selectedTeam->score }}</p>
                                    <p class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em] mt-1.5">Punkte</p>
                                </div>
                                <div class="bg-white px-3 py-4 text-center">
                                    <p class="lp-display text-3xl leading-none">{{ $overallRanking ? $overallRanking . '/' . $totalTeams : '–' }}</p>
                                    <p class="lp-muted text-[0.6rem] font-bold uppercase tracking-[0.2em] mt-1.5">Platz</p>
                                </div>
                            </div>

                            <div class="lp-barcode mt-6"></div>
                        </div>
                    </div>

                    {{-- Aktionen --}}
                    <div class="flex flex-wrap justify-center gap-3 mt-8 lp-reveal lp-d2">
                        <button type="button" onclick="lpOpenModal('lp-qr-modal')" class="lp-btn-primary text-xs px-5 py-3">
                            QR-Code anzeigen
                        </button>
                        @if($lpHasMembers)
                            <button type="button" onclick="lpOpenMembersModal()" class="lp-chip lp-tab">👥 Mitglieder</button>
                        @endif
                        @if($selectedTeam->bonus)
                            <button type="button" onclick="lpOpenModal('lp-bonus-modal')" class="lp-chip lp-tab" style="background: var(--lp-gold);">⭐ Bonus</button>
                        @endif
                    </div>

                    {{-- Ergebnisse --}}
                    <div class="mt-12 lp-reveal lp-d3">
                        @if(empty($teamResults))
                            <div class="lp-card lp-shadow p-8 text-center">
                                <p class="lp-muted">Keine Disziplinen gefunden.</p>
                            </div>
                        @else
                            <h2 class="lp-display text-xl md:text-2xl mb-5">Alle Disziplinen</h2>

                            {{-- Desktop: Tabelle --}}
                            <div class="hidden md:block lp-card lp-shadow overflow-hidden">
                                <table class="min-w-full">
                                    <thead style="background: var(--lp-ink);">
                                    <tr>
                                        <th class="py-3.5 px-4 text-left text-[0.62rem] font-extrabold uppercase tracking-[0.2em] text-white/80">Disziplin</th>
                                        <th class="py-3.5 px-4 text-center text-[0.62rem] font-extrabold uppercase tracking-[0.2em] text-white/80">Platz</th>
                                        <th class="py-3.5 px-4 text-center text-[0.62rem] font-extrabold uppercase tracking-[0.2em] text-white/80">Versuch 1</th>
                                        <th class="py-3.5 px-4 text-center text-[0.62rem] font-extrabold uppercase tracking-[0.2em] text-white/80">Versuch 2</th>
                                        <th class="py-3.5 px-4 text-center text-[0.62rem] font-extrabold uppercase tracking-[0.2em] text-white/80">Bestwert</th>
                                        <th class="py-3.5 px-4 text-center text-[0.62rem] font-extrabold uppercase tracking-[0.2em] text-white/80">★ Highscore</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($teamResults as $result)
                                        <tr class="border-t-2 hover:bg-[#F1E9D6] transition-colors" style="border-color: rgba(22, 29, 39, 0.12);">
                                            <td class="py-3.5 px-4">
                                                <span class="font-extrabold break-words">{{ $result['discipline_name'] }}</span>
                                                @if($result['discipline_unit'])
                                                    <span class="lp-muted block text-xs">Einheit: {{ $result['discipline_unit'] }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                @if($result['has_participated'])
                                                    <span class="inline-flex items-center justify-center border-2 lp-bord rounded-xl px-2.5 py-1 font-extrabold text-sm whitespace-nowrap"
                                                          style="{{ $result['position'] <= 3 ? 'background: var(--lp-gold);' : 'background: #fff;' }}">
                                                        {{ $result['position'] }}/{{ $result['total_participants'] }}
                                                    </span>
                                                @else
                                                    <span class="lp-muted italic text-xs">Nicht teilgenommen</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-center font-semibold">{{ $result['scores']['score_1'] ?? '–' }}</td>
                                            <td class="py-3.5 px-4 text-center font-semibold">{{ $result['scores']['score_2'] ?? '–' }}</td>
                                            <td class="py-3.5 px-4 text-center">
                                                @if($result['has_participated'])
                                                    <span class="lp-display text-lg">{{ $result['scores']['best_score'] }}@if($result['discipline_unit']) {{ $result['discipline_unit'] }}@endif</span>
                                                @else
                                                    <span class="lp-muted">–</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                @if($result['highscore'] !== null)
                                                    <span class="font-extrabold" style="color: #A16207;">★ {{ $result['highscore'] }}@if($result['discipline_unit']) {{ $result['discipline_unit'] }}@endif</span>
                                                @else
                                                    <span class="lp-muted">–</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobil: Karten --}}
                            <div class="md:hidden space-y-4">
                                @foreach($teamResults as $result)
                                    <div class="lp-card lp-shadow p-4">
                                        <div class="flex justify-between items-start gap-2">
                                            <h3 class="lp-display text-lg break-words min-w-0">{{ $result['discipline_name'] }}</h3>
                                            @if($result['has_participated'])
                                                <span class="inline-flex items-center justify-center border-2 lp-bord rounded-xl px-2 py-0.5 font-extrabold text-xs whitespace-nowrap shrink-0"
                                                      style="{{ $result['position'] <= 3 ? 'background: var(--lp-gold);' : 'background: #fff;' }}">
                                                    {{ $result['position'] }}/{{ $result['total_participants'] }}
                                                </span>
                                            @endif
                                        </div>

                                        @if($result['has_participated'])
                                            <div class="grid grid-cols-2 gap-3 mt-3 text-sm">
                                                <div>
                                                    <span class="lp-muted text-xs font-bold uppercase tracking-[0.12em]">Versuch 1</span>
                                                    <span class="block font-extrabold">{{ $result['scores']['score_1'] ?? '–' }}</span>
                                                </div>
                                                <div>
                                                    <span class="lp-muted text-xs font-bold uppercase tracking-[0.12em]">Versuch 2</span>
                                                    <span class="block font-extrabold">{{ $result['scores']['score_2'] ?? '–' }}</span>
                                                </div>
                                            </div>
                                            <div class="flex items-end justify-between gap-3 mt-3 pt-3 border-t-2 border-dashed" style="border-color: rgba(22, 29, 39, 0.2);">
                                                <div>
                                                    <span class="lp-muted text-xs font-bold uppercase tracking-[0.12em]">Bestwert</span>
                                                    <span class="lp-display text-2xl block leading-none mt-0.5">{{ $result['scores']['best_score'] }}@if($result['discipline_unit']) {{ $result['discipline_unit'] }}@endif</span>
                                                </div>
                                                <div class="text-right">
                                                    <span class="lp-muted text-xs font-bold uppercase tracking-[0.12em]">★ Highscore</span>
                                                    @if($result['highscore'] !== null)
                                                        <span class="block font-extrabold" style="color: #A16207;">{{ $result['highscore'] }}@if($result['discipline_unit']) {{ $result['discipline_unit'] }}@endif</span>
                                                    @else
                                                        <span class="lp-muted block">–</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <p class="lp-muted italic text-sm mt-2">Nicht teilgenommen</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-10 text-center">
                        <a href="{{ route('laufzettel.index') }}" class="lp-btn-ghost text-xs px-5 py-3">
                            ← Anderes Team suchen
                        </a>
                    </div>
                @endif
            </div>

            {{-- ===== Light-Mode-Modals ===== --}}
            @if($selectedTeam)
                <div id="lp-qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
                     style="background: rgba(22, 29, 39, 0.65);" onclick="lpCloseModal(event, 'lp-qr-modal')">
                    <div class="lp-card lp-shadow w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden"
                         style="background: var(--lp-paper);" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between gap-3 px-5 py-4" style="background: var(--lp-ink);">
                            <h3 class="lp-display text-xl text-white">QR-Code für Stationen</h3>
                            <button type="button" onclick="lpCloseModal(null, 'lp-qr-modal')"
                                    class="shrink-0 w-9 h-9 grid place-items-center rounded-full border-2 border-white/40 text-white text-lg font-extrabold hover:border-white transition-colors">×</button>
                        </div>
                        <div class="p-5 overflow-y-auto">
                            <p class="lp-muted text-sm text-center">
                                Station scannt diesen Code, das Team wird im Klassen-Dashboard direkt
                                vorausgewählt und das Score-Popup öffnet sich.
                            </p>
                            <div class="mt-4 flex justify-center">
                                <div class="relative inline-block lp-card p-3">
                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(240)->margin(1)->errorCorrection('H')->generate($scoreEntryUrl) !!}
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded bg-white border-2 lp-bord p-0.5">
                                        <picture>
                                            <source srcset="{{ asset('img.webp') }}" type="image/webp">
                                            <img src="{{ asset('img.png') }}" alt="Logo" class="h-14 w-14 block">
                                        </picture>
                                    </div>
                                </div>
                            </div>
                            <p class="lp-muted mt-3 text-center text-xs break-all">Ziel: {{ $scoreEntryUrl }}</p>
                        </div>
                    </div>
                </div>

                <div id="lp-members-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
                     style="background: rgba(22, 29, 39, 0.65);" onclick="lpCloseModal(event, 'lp-members-modal')">
                    <div class="lp-card lp-shadow w-full max-w-md max-h-[85vh] flex flex-col overflow-hidden"
                         style="background: var(--lp-paper);" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between gap-3 px-5 py-4" style="background: var(--lp-ink);">
                            <h3 class="lp-display text-xl text-white">Mitglieder</h3>
                            <button type="button" onclick="lpCloseModal(null, 'lp-members-modal')"
                                    class="shrink-0 w-9 h-9 grid place-items-center rounded-full border-2 border-white/40 text-white text-lg font-extrabold hover:border-white transition-colors">×</button>
                        </div>
                        <div id="lp-members-content" class="p-5 overflow-y-auto space-y-2"></div>
                    </div>
                </div>

                <div id="lp-bonus-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
                     style="background: rgba(22, 29, 39, 0.65);" onclick="lpCloseModal(event, 'lp-bonus-modal')">
                    <div class="lp-card lp-shadow w-full max-w-md flex flex-col overflow-hidden"
                         style="background: var(--lp-paper);" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-between gap-3 px-5 py-4" style="background: var(--lp-gold);">
                            <h3 class="lp-display text-xl">⭐ Bonus</h3>
                            <button type="button" onclick="lpCloseModal(null, 'lp-bonus-modal')"
                                    class="shrink-0 w-9 h-9 grid place-items-center rounded-full border-2 lp-bord text-lg font-extrabold hover:bg-white/40 transition-colors">×</button>
                        </div>
                        <div class="p-5 flex items-start gap-3">
                            <span class="text-3xl" aria-hidden="true">👕</span>
                            <div>
                                <p class="font-extrabold">Bonus für passende Outfits</p>
                                <p class="lp-muted text-sm mt-1.5 leading-relaxed">
                                    Dieses Team hat passende Outfits als Team getragen und erhält dafür
                                    Bonus-Punkte in der Gesamtwertung.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <div class="lp-checker h-4 border-t-2 lp-bord" aria-hidden="true"></div>
    </div>

    {{-- ===================== DARK MODE – unverändert ===================== --}}
    <div class="dark-mode-only">
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

    @if($selectedTeam)
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
                        <div class="relative inline-block rounded-lg border border-gray-200 bg-white p-3 shadow dark:border-gray-700">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(260)->margin(1)->errorCorrection('H')->generate($scoreEntryUrl) !!}
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded bg-white" style="padding: 2px; outline: 2px solid transparent; box-shadow: 0 0 0 2px transparent; border: 2px solid; border-image: linear-gradient(135deg, #f00, #ff7700, #ff0, #0f0, #00f, #8b00ff) 1">
                                <picture>
                                    <source srcset="{{ asset('img.webp') }}" type="image/webp">
                                    <img src="{{ asset('img.png') }}" alt="Logo" class="h-16 w-16 block">
                                </picture>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 text-center text-xs text-gray-500 dark:text-gray-400 break-all">
                        Ziel: {{ $scoreEntryUrl }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @endif

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
    </div>

    @if(isset($teamsForJs) && isset($colorMapForJs))
        <script>
            // Daten für JavaScript verfügbar machen
            const allTeamsData = @json($teamsForJs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
            const colorMap = @json($colorMapForJs);
            const isAdmin = @json($isAdmin ?? false);
            const teamMembers = @json($selectedTeam->members ?? null, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        </script>
    @endif

    <script>
        function openQrModal() {
            const qrModal = document.getElementById('qrModal');
            if (!qrModal) return;
            qrModal.classList.remove('hidden');
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
                content.innerHTML = '';
                membersData.forEach(member => {
                    const div = document.createElement('div');
                    div.className = 'flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-700 rounded transition-colors duration-300';
                    const dot = document.createElement('div');
                    dot.className = 'w-2 h-2 bg-blue-500 dark:bg-blue-400 rounded-full transition-colors duration-300';
                    const span = document.createElement('span');
                    span.className = 'text-sm text-gray-700 dark:text-gray-200 transition-colors duration-300';
                    span.textContent = member;
                    div.appendChild(dot);
                    div.appendChild(span);
                    content.appendChild(div);
                });
            }

            document.getElementById('membersModal').classList.remove('hidden');
        }

        function openBonusModal() {
            document.getElementById('bonusModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // ===================== Light Mode (Poster-Design) =====================

        function lpOpenModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function lpCloseModal(event, id) {
            if (event && event.target !== event.currentTarget) return;
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function lpOpenMembersModal() {
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

            const content = document.getElementById('lp-members-content');
            content.innerHTML = '';

            if (!membersData || !Array.isArray(membersData) || membersData.length === 0) {
                const empty = document.createElement('p');
                empty.className = 'lp-muted text-sm';
                empty.textContent = 'Keine Mitglieder gefunden.';
                content.appendChild(empty);
            } else {
                membersData.forEach((member, index) => {
                    const row = document.createElement('div');
                    row.className = 'flex items-center gap-3 p-2.5 bg-white border-2 rounded-xl';
                    row.style.borderColor = 'rgba(22, 29, 39, 0.15)';

                    const num = document.createElement('span');
                    num.className = 'lp-display text-sm w-6 text-center shrink-0';
                    num.textContent = index + 1;

                    const name = document.createElement('span');
                    name.className = 'font-semibold text-sm break-words min-w-0';
                    name.textContent = member;

                    row.appendChild(num);
                    row.appendChild(name);
                    content.appendChild(row);
                });
            }

            lpOpenModal('lp-members-modal');
        }

        // Team-Suche (Light Mode, nur auf der Such-Seite aktiv)
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('lp-team-search');
            const results = document.getElementById('lp-laufzettel-results');
            if (!input || !results) return;

            const laufzettelBase = '{{ url('/laufzettel') }}';

            function lpSchoolDot(schoolId) {
                const colors = colorMap[schoolId] || colorMap['default'] || {};
                const dot = document.createElement('span');
                dot.className = 'inline-block w-2.5 h-2.5 rounded-full ' + (colors['dot'] || 'bg-gray-400') + ' border border-black/30 align-middle mr-1.5';
                return dot;
            }

            const lpIsAdmin = typeof isAdmin !== 'undefined' && isAdmin;

            function lpStyleBonusBtn(btn, hasBonus) {
                btn.className = 'shrink-0 px-2.5 py-1 rounded-full border-2 lp-bord text-[0.62rem] font-extrabold uppercase tracking-[0.12em] cursor-pointer transition-colors whitespace-nowrap';
                btn.style.background = hasBonus ? 'var(--lp-gold)' : '#fff';
                btn.textContent = hasBonus ? '⭐ Bonus' : '⭕ Kein Bonus';
            }

            function lpToggleBonus(team, btn) {
                btn.disabled = true;
                btn.textContent = '⏳';

                fetch('/team/' + team.id + '/toggle-bonus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            team.bonus = data.bonus;
                        } else {
                            alert('Fehler beim Aktualisieren des Bonus-Status');
                        }
                        lpStyleBonusBtn(btn, team.bonus);
                    })
                    .catch(() => {
                        alert('Fehler beim Aktualisieren des Bonus-Status');
                        lpStyleBonusBtn(btn, team.bonus);
                    })
                    .finally(() => {
                        btn.disabled = false;
                    });
            }

            input.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                results.innerHTML = '';
                if (query.length < 2) return;

                const matches = allTeamsData
                    .filter((team) => team.name.toLowerCase().includes(query))
                    .slice(0, 8);

                if (!matches.length) {
                    const empty = document.createElement('p');
                    empty.className = 'lp-muted text-center text-sm py-4';
                    empty.textContent = 'Kein Team gefunden.';
                    results.appendChild(empty);
                    return;
                }

                matches.forEach((team) => {
                    const card = document.createElement('div');
                    card.className = 'lp-card lp-shadow block p-4 transition-transform duration-200 hover:-translate-y-0.5 cursor-pointer';
                    card.addEventListener('click', function () {
                        window.location.href = laufzettelBase + '/' + team.id;
                    });

                    const top = document.createElement('div');
                    top.className = 'flex flex-wrap items-center justify-between gap-2';

                    const name = document.createElement('span');
                    name.className = 'font-extrabold break-words min-w-0 flex-1 basis-40';
                    name.appendChild(lpSchoolDot(team.school_id));
                    name.appendChild(document.createTextNode(team.name));

                    const right = document.createElement('span');
                    right.className = 'flex items-center gap-2 shrink-0';

                    if (lpIsAdmin) {
                        const bonusBtn = document.createElement('button');
                        bonusBtn.type = 'button';
                        lpStyleBonusBtn(bonusBtn, team.bonus);
                        bonusBtn.addEventListener('click', function (event) {
                            event.stopPropagation();
                            lpToggleBonus(team, bonusBtn);
                        });
                        right.appendChild(bonusBtn);
                    }

                    const arrow = document.createElement('span');
                    arrow.className = 'text-lg font-extrabold shrink-0';
                    arrow.textContent = '→';
                    right.appendChild(arrow);

                    top.appendChild(name);
                    top.appendChild(right);

                    const sub = document.createElement('p');
                    sub.className = 'lp-muted text-xs mt-1 break-words';
                    sub.textContent = team.klasse_name + ' – ' + team.school_name + (team.bonus && !lpIsAdmin ? ' · ⭐ Bonus' : '');

                    card.appendChild(top);
                    card.appendChild(sub);
                    results.appendChild(card);
                });
            });
        });
    </script>
    @push('scripts')
        @vite(['resources/js/laufzettel-search.js'])
    @endpush
</x-layout>
