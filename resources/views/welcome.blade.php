<x-layout>
    @livewireStyles

    <section class="relative pt-10 pb-16 md:pb-24 bg-gradient-to-br from-blue-100 to-green-100 overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col items-center text-center">

                {{-- Logo oder Haupt-Icon --}}
                <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
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

                {{-- 5 Feature Slides --}}
                <div class="w-full max-w-4xl mx-auto relative">
                    <div class="overflow-hidden rounded-xl">
                        <div id="slideshow-container" class="flex transition-transform duration-500 ease-in-out" style="width: 500%;">
                            {{-- Slide 1: Ranking & Live Auswertung --}}
                            <div class="w-full flex-shrink-0 px-4" style="width: 20%;">
                                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center min-h-[320px]">
                                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">🏆 Ranking & Live Auswertung</h3>
                                    <div class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        <ul class="space-y-3 text-left">
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                                Live Ranglisten für Schulen, Klassen & Teams
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                                Intelligente Suchfunktion & Filter
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                                Automatische Platzberechnung in Echtzeit
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 2: Verwaltung & Stammdaten --}}
                            <div class="w-full flex-shrink-0 px-4" style="width: 20%;">
                                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center min-h-[320px]">
                                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-8 w-8 text-teal-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">⚙️ Verwaltung & Stammdaten</h3>
                                    <div class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        <ul class="space-y-3 text-left">
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                                                Schulen, Klassen & Teams verwalten
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                                                Disziplinen & Bewertungssystem konfigurieren
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                                                Komplette Score-Neuberechnung
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 3: Punkte erfassen --}}
                            <div class="w-full flex-shrink-0 px-4" style="width: 20%;">
                                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center min-h-[320px]">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">📊 Punkte erfassen</h3>
                                    <div class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        <ul class="space-y-3 text-left">
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                2 Versuche pro Team mit Bestleistung
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                Sofortige Ranglistenaktualisierung
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                                Übersichtliche Teamverwaltung
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 4: Welcome Page Features --}}
                            <div class="w-full flex-shrink-0 px-4" style="width: 20%;">
                                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center min-h-[320px]">
                                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">🏠 Welcome Page</h3>
                                    <div class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        <ul class="space-y-3 text-left">
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Live Statistiken & Teilnehmerzahlen
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Community-Diskussionen
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Direkter Zugang zu allen Bereichen
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 5: Laufzettel --}}
                            <div class="w-full flex-shrink-0 px-4" style="width: 20%;">
                                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 flex flex-col items-center text-center min-h-[320px]">
                                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-4">📋 Laufzettel</h3>
                                    <div class="text-gray-600 text-sm leading-relaxed flex-grow">
                                        <ul class="space-y-3 text-left">
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                                Persönlicher Laufzettel pro Team
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                                Übersicht aller Disziplinen & Fortschritt
                                            </li>
                                            <li class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                                Ergebnisse & aktuelle Platzierungen
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Slide Indicators (5 Punkte) --}}
                    <div class="flex justify-center mt-8 space-x-2">
                        <button class="slide-indicator w-3 h-3 rounded-full bg-indigo-600 transition-all duration-300" data-slide="0"></button>
                        <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 transition-all duration-300" data-slide="1"></button>
                        <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 transition-all duration-300" data-slide="2"></button>
                        <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 transition-all duration-300" data-slide="3"></button>
                        <button class="slide-indicator w-3 h-3 rounded-full bg-gray-300 transition-all duration-300" data-slide="4"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Rest der Seite bleibt unverändert --}}
    <section class="py-12 md:py-16 bg-gradient-to-br from-slate-50 to-gray-100 border-t border-gray-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Olympiade im Überblick</h2>
                <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                    Aktuelle Zahlen und Fakten zur Campus Olympiade
                </p>
            </div>

            <div class="grid grid-cols-3 gap-3 md:gap-6 max-w-4xl mx-auto mb-8">
                {{-- Schulen Counter --}}
                <a href="{{ url('/ranking') }}" class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 20v-9l-4 1.125V20h4Zm0 0h8m-8 0V6.66667M16 20v-9l4 1.125V20h-4Zm0 0V7m0 0V4h4v3h-4ZM6 8l6-4 4 2.66667M11 9h2m-2 3h2"/>
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
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
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
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>
                        </div>
                        <div class="text-2xl md:text-3xl font-bold text-emerald-600 mb-1">{{ $teamCount }}</div>
                        <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Teams</div>
                        <div class="text-xs text-gray-500 mt-1 hidden md:block">im Wettbewerb</div>
                    </div>
                </a>
            </div>

            {{-- Besucher Counter --}}
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

    {{-- Kommentare --}}
    <section class="py-16 bg-gradient-to-br from-blue-100 to-green-100">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">
                Community Diskussionen
            </h2>

            @livewire('comments')
        </div>
    </section>

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('slideshow-container');
            const indicators = document.querySelectorAll('.slide-indicator');
            let currentSlide = 0;
            const totalSlides = 5;
            const slideInterval = 5000; // 5 Sekunden
            let slideshow;

            function showSlide(slideIndex) {
                // Stelle sicher, dass slideIndex im gültigen Bereich ist
                if (slideIndex < 0) slideIndex = 0;
                if (slideIndex >= totalSlides) slideIndex = totalSlides - 1;

                const offset = -(slideIndex * 20); // 20% pro Slide (100% / 5 Slides)
                container.style.transform = `translateX(${offset}%)`;

                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === slideIndex) {
                        indicator.classList.remove('bg-gray-300');
                        indicator.classList.add('bg-indigo-600');
                    } else {
                        indicator.classList.remove('bg-indigo-600');
                        indicator.classList.add('bg-gray-300');
                    }
                });

                currentSlide = slideIndex;
            }

            function nextSlide() {
                const nextIndex = (currentSlide + 1) % totalSlides;
                showSlide(nextIndex);
            }

            function startSlideshow() {
                // Stoppe alle vorherigen Intervalle
                if (slideshow) {
                    clearInterval(slideshow);
                }
                // Starte neues Intervall
                slideshow = setInterval(nextSlide, slideInterval);
            }

            function stopSlideshow() {
                if (slideshow) {
                    clearInterval(slideshow);
                }
            }

            // Initialisiere Slideshow
            startSlideshow();

            // Indicator Click Events
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    stopSlideshow();
                    showSlide(index);
                    startSlideshow();
                });
            });

            // Pause bei Hover
            const slideshowWrapper = container.parentElement;
            slideshowWrapper.addEventListener('mouseenter', stopSlideshow);
            slideshowWrapper.addEventListener('mouseleave', startSlideshow);

            // Cleanup bei Seitenwechsel
            window.addEventListener('beforeunload', stopSlideshow);
        });
    </script>
</x-layout>
