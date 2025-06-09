<x-layout>
    @livewireStyles

    {{-- Kein expliziter Header-Slot hier, da der Hero die Überschrift übernimmt --}}
    {{-- <x-slot:heading>Willkommen</x-slot:heading> --}}

    {{-- Hero Section - Angelehnt an das React-Beispiel --}}
    <section class="relative pt-24 md:pt-32 pb-16 md:pb-24 bg-gradient-to-b from-indigo-50 via-white to-gray-50 overflow-hidden">
        {{-- Dekorative Hintergrundelemente (einfacher als im React-Beispiel) --}}
        <div class="absolute top-0 left-0 -translate-x-1/4 -translate-y-1/4 w-96 h-96 bg-indigo-200 rounded-full opacity-30 blur-3xl" aria-hidden="true"></div>
        <div class="absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 w-80 h-80 bg-blue-200 rounded-full opacity-30 blur-3xl" aria-hidden="true"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col items-center text-center">
                {{-- Logo oder Haupt-Icon --}}
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
                    {{-- Ranking Icon als Hauptsymbol --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="7"></circle>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                    </svg>
                </div>

                {{-- Überschrift und Text --}}
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    <span class="text-indigo-600">Campus Olympiade</span> - Dein Portal zum Wettbewerb
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Verfolge live die Ranglisten deiner Schule, Klasse und deines Teams. Lehrer und Admins können sich hier einloggen, um Ergebnisse einzutragen und den Wettbewerb zu verwalten.
                </p>

                {{-- Buttons mit Hover-Effekt --}}
                <div class="flex flex-wrap justify-center gap-4 mb-16">
                    <a href="{{ url('/ranking') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white text-base font-medium rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        Ranking ansehen
                    </a>
                    <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-indigo-600 text-base font-medium rounded-lg border border-indigo-300 shadow-sm hover:bg-indigo-50 hover:shadow-lg hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        Login für Lehrer & Admins
                    </a>
                </div>

                {{-- Drei Feature Boxen mit Hover-Effekt und Links --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mx-auto">
                    {{-- Feature 1: Ranking --}}
                    <a href="{{ url('/ranking') }}" class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-200 block">
                        <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mb-5">
                            {{-- Ranking Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Live Ranglisten</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Sieh jederzeit die aktuellen Platzierungen der Schulen, Klassen und Teams ein. Wer führt gerade?
                        </p>
                    </a>

                    {{-- Feature 2: Teacher --}}
                    <a href="{{ url('/teacher') }}" class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-200 block">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                            {{-- Teacher Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dateneingabe (Lehrer)</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Lehrer können sich anmelden, um die Ergebnisse ihrer Teams in den verschiedenen Disziplinen einzutragen.
                        </p>
                    </a>

                    {{-- Feature 3: Admin --}}
                    <a href="{{ url('/admin') }}" class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-200 block">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-5">
                            {{-- Admin Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-7 w-7 text-green-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Verwaltung (Admin)</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Administratoren legen Schulen, Klassen, Teams und Disziplinen an und verwalten die Stammdaten.
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ÜBERARBEITETE STATISTIK SEKTION --}}
    <section class="py-12 md:py-16 bg-gradient-to-br from-slate-50 to-gray-100 border-t border-gray-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Olympiade im Überblick</h2>
                <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                    Aktuelle Zahlen und Fakten zur Campus Olympiade
                </p>
            </div>

            {{-- Hauptstatistiken als klickbare Links --}}
            <div class="grid grid-cols-3 gap-3 md:gap-6 max-w-4xl mx-auto mb-8">
                {{-- Schulen Counter --}}
                <a href="{{ url('/ranking') }}" class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            {{-- Besseres Schulen Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-indigo-600 mb-1">{{ $schoolCount }}</div>
                        <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Schulen</div>
                        <div class="text-xs text-gray-500 mt-1 hidden md:block">teilnehmend</div>
                    </div>
                </a>

                {{-- Klassen Counter --}}
                <a href="{{ url('/ranking') }}" class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            {{-- Neues besseres Klassen Icon - Benutzer-Gruppen --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-blue-600 mb-1">{{ $klasseCount }}</div>
                        <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Klassen</div>
                        <div class="text-xs text-gray-500 mt-1 hidden md:block">registriert</div>
                    </div>
                </a>

                {{-- Teams Counter --}}
                <a href="{{ url('/ranking') }}" class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-emerald-600 mb-1">{{ $teamCount }}</div>
                        <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Teams</div>
                        <div class="text-xs text-gray-500 mt-1 hidden md:block">im Wettbewerb</div>
                    </div>
                </a>
            </div>

            {{-- Besucher Counter - kleiner und separiert --}}
            <div class="max-w-sm mx-auto">
                <div class="bg-white/70 rounded-lg shadow-sm p-3 border border-gray-200/50 text-center">
                    <div class="flex items-center justify-center gap-2 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span class="text-sm">
                            <strong class="text-purple-600">{{ number_format($visitcount->total_visits ?? 0) }}</strong>
                            Besuche insgesamt
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Community / Kommentar Sektion - Design etwas angepasst --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-100">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">
                    Community Diskussionen
                </h2>
                {{-- Livewire Comments Component --}}
                @livewire('comments')
            </div>
        </div>
    </section>

    @livewireScripts
</x-layout>
