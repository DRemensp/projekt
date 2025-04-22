{{-- resources/views/welcome.blade.php --}}
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

                {{-- Buttons --}}
                <div class="flex flex-wrap justify-center gap-4 mb-16">
                    <a href="{{ url('/ranking') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white text-base font-medium rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        Ranking ansehen
                    </a>
                    <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-indigo-600 text-base font-medium rounded-lg border border-indigo-300 shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        Login für Lehrer & Admins
                    </a>
                </div>

                {{-- Drei Feature Boxen - Inhalt angepasst --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mx-auto">
                    {{-- Feature 1: Ranking --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center transition-shadow hover:shadow-indigo-100">
                        <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mb-5">
                            {{-- Ranking Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Live Ranglisten</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Sieh jederzeit die aktuellen Platzierungen der Schulen, Klassen und Teams ein. Wer führt gerade?
                        </p>
                    </div>

                    {{-- Feature 2: Teacher --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center transition-shadow hover:shadow-blue-100">
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-5">
                            {{-- Teacher Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dateneingabe (Lehrer)</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Lehrer können sich anmelden, um die Ergebnisse ihrer Teams in den verschiedenen Disziplinen einzutragen.
                        </p>
                    </div>

                    {{-- Feature 3: Admin --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center transition-shadow hover:shadow-green-100">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-5">
                            {{-- Admin Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-7 w-7 text-green-600"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Verwaltung (Admin)</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Administratoren legen Schulen, Klassen, Teams und Disziplinen an und verwalten die Stammdaten.
                        </p>
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
