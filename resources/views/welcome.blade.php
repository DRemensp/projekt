<x-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap');

        .light-mode-only {
            display: block;
        }

        .dark-mode-only {
            display: none;
        }

        .dark .light-mode-only {
            display: none;
        }

        .dark .dark-mode-only {
            display: block;
        }

        .dark .dark-mode-only {
            --night-0: #0a0f14;
            --night-1: #0f172a;
            --night-2: #141c2b;
            --ink-0: #e6edf7;
            --ink-1: #b5c0d3;
            --accent-teal: #2dd4bf;
            --accent-blue: #60a5fa;
            --accent-amber: #f59e0b;
            --accent-rose: #fb7185;
            --line: rgba(148, 163, 184, 0.2);
            font-family: "Manrope", sans-serif;
            color: var(--ink-0);
        }

        .dark .dark-mode-only .display-font {
            font-family: "Space Grotesk", sans-serif;
            letter-spacing: -0.02em;
        }

        .aurora-sky {
            background: radial-gradient(1200px circle at 12% 0%, rgba(45, 212, 191, 0.18), transparent 60%),
            radial-gradient(900px circle at 90% 12%, rgba(96, 165, 250, 0.22), transparent 55%),
            radial-gradient(700px circle at 30% 85%, rgba(245, 158, 11, 0.16), transparent 60%),
            linear-gradient(180deg, #0a0f14 0%, #0b1320 45%, #0b0f17 100%);
        }

        .aurora-grid {
            background-image: radial-gradient(rgba(148, 163, 184, 0.25) 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.35;
            animation: gridPulse 8s ease-in-out infinite;
        }

        .parallax-layer {
            transform: translate3d(0, 0, 0);
            will-change: transform;
        }

        @keyframes gridPulse {
            0%, 100% {
                opacity: 0.35;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.02);
            }
        }

        .hero-orb {
            animation: drift 12s ease-in-out infinite;
        }

        .glow-dot {
            position: absolute;
            border-radius: 9999px;
            filter: blur(3px);
            box-shadow: 0 0 30px currentColor, 0 0 60px currentColor, 0 0 90px currentColor;
            animation: glowFloat 6s ease-in-out infinite, glowPulse 3s ease-in-out infinite;
            opacity: 0.8;
        }

        @media (max-width: 767px) {
            .dark .module-carousel-shell {
                position: relative;
                overflow-x: hidden;
                overflow-y: visible;
                perspective: 1200px;
                padding: 0.75rem 1.5rem;
            }

            .dark .module-carousel {
                display: flex;
                flex-wrap: nowrap;
                gap: 1rem;
                transition: transform 0.7s ease;
                will-change: transform;
            }

            .dark .module-carousel .module-card {
                flex: 0 0 78%;
                max-width: 78%;
                transform-origin: center;
                transition: transform 0.7s ease, opacity 0.7s ease;
                animation: none;
            }

            .dark .module-carousel .module-card.is-active {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1.05);
            }

            .dark .module-carousel .module-card.is-prev {
                opacity: 0.7;
                transform: translate3d(-6%, 8px, -80px) scale(0.92);
            }

            .dark .module-carousel .module-card.is-next {
                opacity: 0.7;
                transform: translate3d(6%, 8px, -80px) scale(0.92);
            }

            .dark .module-carousel .module-card.is-off {
                opacity: 0;
                pointer-events: none;
                transform: translate3d(0, 16px, -120px) scale(0.9);
            }
        }

        @keyframes glowFloat {
            0%, 100% {
                transform: translate(0, 0);
            }
            25% {
                transform: translate(15px, -15px);
            }
            50% {
                transform: translate(-10px, -20px);
            }
            75% {
                transform: translate(-20px, 10px);
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.4;
                transform: scale(1);
            }
            50% {
                opacity: 1;
                transform: scale(1.5);
            }
        }

        .dark .pulse-dot {
            background: var(--accent-teal);
            box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.6);
            animation: pulse 2.2s infinite;
        }

        .dark .cta-primary {
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-blue));
        }

        .dark .cta-primary::after {
            content: '';
            position: absolute;
            inset: -100% 0 0 -100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.45), transparent);
            transform: translateX(-60%);
            transition: transform 0.7s ease;
            z-index: 0;
        }

        .dark .cta-primary:hover::after {
            transform: translateX(60%);
        }

        .dark .score-cell::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.08), transparent);
            opacity: 0;
            transform: translateX(-40%);
            transition: opacity 0.3s ease, transform 0.6s ease;
        }

        .dark .score-cell:hover::after {
            opacity: 1;
            transform: translateX(40%);
        }

        .dark .tag-chip {
            color: var(--ink-1);
        }

        .dark .section-kicker {
            color: var(--accent-blue);
        }

        .dark .module-card {
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.92), rgba(7, 10, 18, 0.95));
        }

        .dark .module-icon {
            color: var(--accent-teal);
        }

        .dark .flow-card {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.85), rgba(8, 11, 20, 0.95));
        }

        .dark .community-shell {
            background: linear-gradient(140deg, rgba(12, 18, 30, 0.9), rgba(7, 10, 18, 0.95));
        }

        .dark .scoreboard-panel {
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.9), rgba(7, 10, 18, 0.96));
        }

        .dark .reveal {
            animation: rise 0.9s ease both;
        }

        .dark .delay-1 {
            animation-delay: 0.1s;
        }

        .dark .delay-2 {
            animation-delay: 0.2s;
        }

        .dark .delay-3 {
            animation-delay: 0.3s;
        }

        .dark .delay-4 {
            animation-delay: 0.4s;
        }

        @keyframes drift {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            50% {
                transform: translateY(-18px) translateX(10px);
            }
        }

        @keyframes rise {
            0% {
                opacity: 0;
                transform: translateY(18px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.6);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(45, 212, 191, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(45, 212, 191, 0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .dark .hero-orb,
            .dark .reveal,
            .dark .pulse-dot,
            .dark .cta-primary::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <div class="light-mode-only">
        <section class="relative pt-10 pb-16 md:pb-24 bg-gradient-to-br from-blue-100 to-green-100 overflow-hidden">
            <div class="container mx-auto px-4 relative z-10">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="8" r="7"></circle>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                        </svg>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        <span class="text-indigo-600">Campus Olympiade</span> - Dein Portal zum Wettbewerb
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                        Verfolge live die Ranglisten deiner Schule, Klasse und deines Teams. Du kannst dich hier
                        einloggen, um Ergebnisse einzutragen und den Wettbewerb zu verwalten.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 mb-16">
                        <a href="{{ url('/ranking') }}"
                           class="inline-flex items-center gap-2 px-8 py-3 bg-indigo-600 text-white text-base font-medium rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            Ranking ansehen
                        </a>
                        <a href="{{ url('/login') }}"
                           class="inline-flex items-center gap-2 px-8 py-3 bg-white text-indigo-600 text-base font-medium rounded-lg border border-indigo-300 shadow-sm hover:bg-indigo-50 hover:shadow-lg hover:-translate-y-1 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Login für Berechtigte
                        </a>
                    </div>

                    <div class="w-full max-w-6xl mx-auto relative">
                        <div class="overflow-hidden rounded-xl">
                            <div id="slideshow-container-light"
                                 class="flex transition-transform duration-500 ease-in-out">
                                <!-- Slide 1 -->
                                <div class="w-full md:w-1/3 flex-shrink-0 px-2">
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-100 flex flex-col items-center text-center h-full">
                                        <div
                                            class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="8" r="7"></circle>
                                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">🏆 Ranking & Live
                                            Auswertung</h3>
                                        <ul class="space-y-2 text-left text-sm text-gray-600">
                                            <li>• Live Ranglisten</li>
                                            <li>• Suchfunktion & Filter</li>
                                            <li>• Echtzeit-Platzberechnung</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Slide 2 -->
                                <div class="w-full md:w-1/3 flex-shrink-0 px-2">
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-100 flex flex-col items-center text-center h-full">
                                        <div
                                            class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-teal-600"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">⚙️ Verwaltung &
                                            Stammdaten</h3>
                                        <ul class="space-y-2 text-left text-sm text-gray-600">
                                            <li>• Schulen & Teams verwalten</li>
                                            <li>• Disziplinen konfigurieren</li>
                                            <li>• Score-Neuberechnung</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Slide 3 -->
                                <div class="w-full md:w-1/3 flex-shrink-0 px-2">
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-100 flex flex-col items-center text-center h-full">
                                        <div
                                            class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">📊 Punkte erfassen</h3>
                                        <ul class="space-y-2 text-left text-sm text-gray-600">
                                            <li>• 2 Versuche pro Team</li>
                                            <li>• Sofortige Aktualisierung</li>
                                            <li>• Teamverwaltung</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Slide 4 -->
                                <div class="w-full md:w-1/3 flex-shrink-0 px-2">
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-100 flex flex-col items-center text-center h-full">
                                        <div
                                            class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M3 9.75L12 4l9 5.75V20a1 1 0 0 1-1 1h-5.25a.75.75 0 0 1-.75-.75V13.5h-4.5v6.75a.75.75 0 0 1-.75.75H4a1 1 0 0 1-1-1Z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">🏠 Welcome Page</h3>
                                        <ul class="space-y-2 text-left text-sm text-gray-600">
                                            <li>• Live Statistiken</li>
                                            <li>• Community-Diskussionen</li>
                                            <li>• Direkter Zugang</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Slide 5 -->
                                <div class="w-full md:w-1/3 flex-shrink-0 px-2">
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-100 flex flex-col items-center text-center h-full">
                                        <div
                                            class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M9 4h6a2 2 0 0 1 2 2v14l-5-3-5 3V6a2 2 0 0 1 2-2Z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">📋 Laufzettel</h3>
                                        <ul class="space-y-2 text-left text-sm text-gray-600">
                                            <li>• Persönliche Übersicht</li>
                                            <li>• Disziplinen & Fortschritt</li>
                                            <li>• Aktuelle Platzierungen</li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Slide 6 -->
                                <div class="w-full md:w-1/3 flex-shrink-0 px-2">
                                    <div
                                        class="bg-white p-5 rounded-lg shadow-md border border-gray-100 flex flex-col items-center text-center h-full">
                                        <div
                                            class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M3 7h18M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2m-8 8h6M5 7v13a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">📚 Archiv & Historie</h3>
                                        <ul class="space-y-2 text-left text-sm text-gray-600">
                                            <li>• Vergangene Wettbewerbe</li>
                                            <li>• Detaillierte Rankings</li>
                                            <li>• Historische Statistiken</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-6 space-x-2">
                            <button class="slide-indicator-light w-2.5 h-2.5 rounded-full bg-indigo-600 transition-all"
                                    data-slide="0"></button>
                            <button class="slide-indicator-light w-2.5 h-2.5 rounded-full bg-gray-300 transition-all"
                                    data-slide="1"></button>
                            <button class="slide-indicator-light w-2.5 h-2.5 rounded-full bg-gray-300 transition-all"
                                    data-slide="2"></button>
                            <button class="slide-indicator-light w-2.5 h-2.5 rounded-full bg-gray-300 transition-all"
                                    data-slide="3"></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 md:py-16 bg-gradient-to-br from-slate-50 to-gray-100 border-t border-gray-200">
            <div class="container mx-auto px-4">
                <div class="text-center mb-8 md:mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Olympiade im Überblick</h2>
                    <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">Live Zahlen zur Campus Olympiade im
                        Überblick</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 max-w-5xl mx-auto mb-8">
                    <a href="{{ url('/ranking') }}"
                       class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2.2"
                                          d="M8 20v-9l-4 1.125V20h4Zm0 0h8m-8 0V6.66667M16 20v-9l4 1.125V20h-4Zm0 0V7m0 0V4h4v3h-4ZM6 8l6-4 4 2.66667M11 9h2m-2 3h2"/>
                                </svg>
                            </div>
                            <div class="text-2xl md:text-3xl font-bold text-indigo-600 mb-1">{{ $schoolCount }}</div>
                            <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Schulen
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/ranking') }}"
                       class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
                                </svg>
                            </div>
                            <div class="text-2xl md:text-3xl font-bold text-blue-600 mb-1">{{ $klasseCount }}</div>
                            <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Klassen
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/ranking') }}"
                       class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </div>
                            <div class="text-2xl md:text-3xl font-bold text-emerald-600 mb-1">{{ $teamCount }}</div>
                            <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Teams
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/ranking') }}"
                       class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group block">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="w-12 h-12 md:w-16 md:h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl md:rounded-2xl flex items-center justify-center mb-3 md:mb-4 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                          d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </div>
                            <div class="text-2xl md:text-3xl font-bold text-orange-600 mb-1">{{ $studentCount }}</div>
                            <div class="text-xs md:text-sm font-medium text-gray-600 uppercase tracking-wide">Schüler
                            </div>
                        </div>
                    </a>
                </div>
                <div class="max-w-sm mx-auto">
                    <div class="bg-white/70 rounded-lg shadow-sm p-3 border border-gray-200/50 text-center">
                        <div class="flex items-center justify-center gap-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span class="text-sm"><strong
                                    class="text-purple-600">{{ number_format($visitcount->total_visits ?? 0) }}</strong> Besuche insgesamt</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-gradient-to-br from-blue-100 to-green-100">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Community Diskussionen</h2>
                <livewire:comments/>
            </div>
        </section>
    </div>

    <div class="dark-mode-only relative z-0 min-h-screen overflow-x-hidden">
        <div class="relative z-10">
            <section class="relative overflow-hidden pt-8 md:py-24">

                <div class="container mx-auto px-4 relative z-10">
                    <div class="grid lg:grid-cols-[1.1fr,0.9fr] gap-12 items-center">
                        <div class="space-y-8">
                            <div
                                class="hero-kicker reveal inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-slate-900/70 border border-white/25 text-slate-400 uppercase tracking-[0.25em] text-[0.7rem]">
                                <span class="pulse-dot w-2 h-2 rounded-full"></span>
                                Live competition hub
                            </div>
                            <div class="space-y-4">
                                <h1 class="display-font text-5xl md:text-7xl font-semibold leading-tight reveal delay-1">
                                    Campus Olympiade
                                    <span
                                        class="block text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-sky-300 to-amber-200">Live. Fair. Schnell.</span>
                                </h1>
                                <p class="text-lg md:text-xl text-slate-300 max-w-xl reveal delay-2">
                                    Das Wettbewerbszentrum für Schulen, Klassen und Teams. Rankings in Echtzeit, klare
                                    Workflows, starke Community.
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-4 reveal delay-3">
                                <a href="{{ url('/ranking') }}"
                                   class="cta-primary relative isolate overflow-hidden inline-flex items-center gap-3 px-8 py-3.5 rounded-full text-[#0a0f14] font-bold shadow-[0_12px_30px_rgba(45,212,191,0.35)] transition-all duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:shadow-[0_18px_40px_rgba(45,212,191,0.45)]">
                                    <span class="relative z-10">Ranking live</span>
                                    <svg class="relative z-10 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="7"></circle>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                    </svg>
                                </a>
                                <a href="{{ url('/login') }}"
                                   class="inline-flex items-center gap-3 px-8 py-3.5 rounded-full border border-blue-400/45 bg-slate-900/65 text-slate-100 transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-400/80 hover:shadow-[0_12px_28px_rgba(12,18,30,0.6)]">
                                    <span>Admin Login</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                </a>
                            </div>
                            <div class="flex flex-wrap gap-3 text-sm text-slate-300 reveal delay-4">
                                <span
                                    class="tag-chip px-3.5 py-1.5 rounded-full bg-slate-900/70 border border-white/20">Echtzeit Rankings</span>
                                <span
                                    class="tag-chip px-3.5 py-1.5 rounded-full bg-slate-900/70 border border-white/20">Automatische Scores</span>
                                <span
                                    class="tag-chip px-3.5 py-1.5 rounded-full bg-slate-900/70 border border-white/20">Moderation bereit</span>
                            </div>
                        </div>

                        <div class="relative reveal delay-2">
                            <div
                                class="scoreboard-panel rounded-[32px] border border-white/20 p-8 shadow-[0_30px_80px_rgba(4,6,12,0.7)] backdrop-blur-xl">
                                <div
                                    class="flex items-center justify-between text-xs uppercase tracking-[0.3em] text-slate-400">
                                    <span>Live Teilnehmer</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Now</span>
                                </div>
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Schulen</p>
                                        <p class="display-font text-3xl md:text-4xl text-teal-200">{{ $schoolCount }}</p>
                                    </div>
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Klassen</p>
                                        <p class="display-font text-3xl md:text-4xl text-sky-200">{{ $klasseCount }}</p>
                                    </div>
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Teams</p>
                                        <p class="display-font text-3xl md:text-4xl text-emerald-200">{{ $teamCount }}</p>
                                    </div>
                                    <div
                                        class="score-cell bg-[rgba(12,18,30,0.9)] border border-white/[0.18] rounded-[18px] p-4 relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:border-teal-400/35">
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Schüler</p>
                                        <p class="display-font text-3xl md:text-4xl text-amber-200">{{ $studentCount }}</p>
                                    </div>
                                </div>
                                <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-4">
                                    <div class="flex items-center gap-3 text-sm text-slate-400">
                                        <span class="pulse-dot w-2 h-2 rounded-full"></span>
                                        Gesamtbesuche
                                    </div>
                                    <div
                                        class="display-font text-2xl text-amber-200">{{ number_format($visitcount->total_visits ?? 0) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 relative">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col lg:flex-row items-start justify-between gap-8">
                        <div class="space-y-4 max-w-2xl">
                            <p class="section-kicker uppercase tracking-[0.3em] text-[0.7rem]">System Module</p>
                            <h2 class="display-font text-3xl md:text-4xl">Alles, was der Wettbewerb braucht</h2>
                            <p class="text-slate-300">Von der Punktaufnahme bis zum Archiv bleibt jedes Team sichtbar.
                                Klar, schnell, professionell.</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ url('/ranking') }}"
                               class="inline-flex items-center gap-3 px-8 py-3.5 rounded-full border border-blue-400/45 bg-slate-900/65 text-slate-100 transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-400/80 hover:shadow-[0_12px_28px_rgba(12,18,30,0.6)]">Zum
                                Ranking</a>
                        </div>
                    </div>

                    <div class="mt-10 module-carousel-shell">
                        <div class="module-carousel grid md:grid-cols-2 lg:grid-cols-3 gap-6" data-module-carousel>
                            <div
                                class="module-card reveal border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="7"></circle>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Ranking & Live Auswertung</h3>
                                <p class="text-slate-400">Live Ranglisten für Schulen, Klassen und Teams mit sofortigen
                                    Updates.</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Filter</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Suche</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Auto</span>
                                </div>
                            </div>

                            <div
                                class="module-card reveal delay-1 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M12 6V4m0 2a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m-6 8a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m12-4a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4M6 6v10M18 6v10"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Verwaltung & Stammdaten</h3>
                                <p class="text-slate-400">Disziplinen, Schulen und Teams zentral steuern, inklusive
                                    Score-Regeln.</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Konfig</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Sync</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Admins</span>
                                </div>
                            </div>

                            <div
                                class="module-card reveal delay-2 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M3 3v18h18"></path>
                                        <path d="M7 14l4-4 3 3 5-6"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Punkte erfassen</h3>
                                <p class="text-slate-400">Schnelle Eingabe mit Bestleistung-Logik und sofortiger
                                    Platzierung.</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Live</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Teams</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Versuche</span>
                                </div>
                            </div>

                            <div
                                class="module-card reveal border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M3 9.75L12 4l9 5.75V20a1 1 0 0 1-1 1h-5.25a.75.75 0 0 1-.75-.75V13.5h-4.5v6.75a.75.75 0 0 1-.75.75H4a1 1 0 0 1-1-1Z"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Welcome Hub</h3>
                                <p class="text-slate-400">Einstiegspunkt für Stats, Diskussionen und alle
                                    Wettbewerbsbereiche.</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Dashboard</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Live</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Zugriff</span>
                                </div>
                            </div>

                            <div
                                class="module-card reveal delay-1 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M9 4h6a2 2 0 0 1 2 2v14l-5-3-5 3V6a2 2 0 0 1 2-2Z"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Laufzettel</h3>
                                <p class="text-slate-400">Persönliche Übersicht der Disziplinen, Fortschritte und
                                    Ergebnisse.</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Teams</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Progress</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Ergebnis</span>
                                </div>
                            </div>

                            <div
                                class="module-card reveal delay-2 border border-white/20 rounded-3xl p-7 shadow-[0_20px_50px_rgba(4,6,12,0.5)] transition-all duration-[400ms] hover:-translate-y-2 hover:border-teal-400/45 hover:shadow-[0_28px_60px_rgba(4,6,12,0.6)]"
                                data-module-card>
                                <div
                                    class="module-icon mb-5 w-12 h-12 rounded-2xl grid place-items-center bg-slate-900/75 border border-white/25">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M3 7h18M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2m-8 8h6M5 7v13a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7"></path>
                                    </svg>
                                </div>
                                <h3 class="display-font text-xl text-slate-100 mb-2">Archiv & Historie</h3>
                                <p class="text-slate-400">Vergangene Wettbewerbe, detaillierte Rankings und
                                    Vergleichswerte.</p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">History</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Stats</span>
                                    <span
                                        class="tag-chip tag-muted bg-slate-900/40 uppercase tracking-[0.08em] text-[0.7rem] px-3.5 py-1.5 rounded-full border border-white/20">Export</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 relative">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                        <p class="section-kicker uppercase tracking-[0.3em] text-[0.7rem]">Flow</p>
                        <h2 class="display-font text-3xl md:text-4xl">Von der Disziplin zur Rangliste in Sekunden</h2>
                        <p class="text-slate-300">Eingabe, Berechnung und Sichtbarkeit greifen ineinander, damit jede
                            Leistung sofort zählt.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div
                            class="flow-card reveal border border-white/20 rounded-3xl p-8 shadow-[0_24px_60px_rgba(5,8,15,0.55)]">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">01</p>
                            <h3 class="display-font text-xl mt-4 mb-3">Ergebnisse erfassen</h3>
                            <p class="text-slate-400">Disziplinen und Teams per Schnellmaske aktualisieren, ohne
                                Umwege.</p>
                        </div>
                        <div
                            class="flow-card reveal delay-1 border border-white/20 rounded-3xl p-8 shadow-[0_24px_60px_rgba(5,8,15,0.55)]">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">02</p>
                            <h3 class="display-font text-xl mt-4 mb-3">Scores berechnen</h3>
                            <p class="text-slate-400">Bestleistungen werden sofort bewertet und auf die Rangliste
                                gelegt.</p>
                        </div>
                        <div
                            class="flow-card reveal delay-2 border border-white/20 rounded-3xl p-8 shadow-[0_24px_60px_rgba(5,8,15,0.55)]">
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">03</p>
                            <h3 class="display-font text-xl mt-4 mb-3">Ranking live teilen</h3>
                            <p class="text-slate-400">Schulen, Klassen und Teams sehen die Ergebnisse in Echtzeit.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 relative">
                <div class="container mx-auto px-4">
                    <div class="text-center max-w-3xl mx-auto space-y-4 mb-12">
                        <p class="section-kicker uppercase tracking-[0.3em] text-[0.7rem]">Community</p>
                        <h2 class="display-font text-3xl md:text-4xl">Stimmen aus dem Wettbewerb</h2>
                        <p class="text-slate-300">Teile Updates, Motivation und Feedback direkt auf der Plattform.</p>
                    </div>
                    <div
                        class="community-shell border border-white/25 rounded-[32px] p-6 shadow-[0_30px_70px_rgba(5,8,15,0.7)]">
                        <livewire:comments/>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Light mode slideshow
            const containerLight = document.getElementById('slideshow-container-light');
            if (containerLight) {
                const indicatorsLight = document.querySelectorAll('.slide-indicator-light');
                let currentSlideLight = 0;
                const slideIntervalLight = 5000;
                let slideshowLight;

                // Berechne Anzahl der Gruppen basierend auf Viewport
                function getSlidesPerView() {
                    return window.innerWidth >= 768 ? 3 : 1; // 3 auf Desktop, 1 auf Mobile
                }

                function getTotalGroups() {
                    return 6 - getSlidesPerView() + 1; // 6 Slides total, zeige 3 gleichzeitig = 4 Gruppen
                }

                function showSlideLight(slideIndex) {
                    const totalGroups = getTotalGroups();
                    if (slideIndex < 0) slideIndex = 0;
                    if (slideIndex >= totalGroups) slideIndex = totalGroups - 1;

                    const slidesPerView = getSlidesPerView();
                    const slideWidth = 100 / slidesPerView;
                    const offset = -(slideIndex * slideWidth);
                    containerLight.style.transform = `translateX(${offset}%)`;

                    indicatorsLight.forEach((indicator, index) => {
                        if (index === slideIndex) {
                            indicator.classList.remove('bg-gray-300');
                            indicator.classList.add('bg-indigo-600');
                        } else {
                            indicator.classList.remove('bg-indigo-600');
                            indicator.classList.add('bg-gray-300');
                        }
                    });
                    currentSlideLight = slideIndex;
                }

                function nextSlideLight() {
                    const totalGroups = getTotalGroups();
                    const nextIndex = (currentSlideLight + 1) % totalGroups;
                    showSlideLight(nextIndex);
                }

                function startSlideshowLight() {
                    if (slideshowLight) clearInterval(slideshowLight);
                    slideshowLight = setInterval(nextSlideLight, slideIntervalLight);
                }

                function stopSlideshowLight() {
                    if (slideshowLight) clearInterval(slideshowLight);
                }

                startSlideshowLight();

                indicatorsLight.forEach((indicator, index) => {
                    indicator.addEventListener('click', function () {
                        stopSlideshowLight();
                        showSlideLight(index);
                        startSlideshowLight();
                    });
                });

                const slideshowWrapperLight = containerLight.parentElement;
                slideshowWrapperLight.addEventListener('mouseenter', stopSlideshowLight);
                slideshowWrapperLight.addEventListener('mouseleave', startSlideshowLight);
                window.addEventListener('beforeunload', stopSlideshowLight);

                // Bei Resize neu berechnen
                window.addEventListener('resize', function () {
                    showSlideLight(0); // Zurück zum ersten Slide bei Resize
                });
            }

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Dark mode module carousel (mobile)
            const moduleCarousel = document.querySelector('[data-module-carousel]');
            if (moduleCarousel) {
                const cards = Array.from(moduleCarousel.querySelectorAll('[data-module-card]'));
                const shell = moduleCarousel.closest('.module-carousel-shell');
                const mobileQuery = window.matchMedia('(max-width: 767px)');
                let currentIndex = 0;
                let carouselTimer = null;

                function applyModuleClasses() {
                    const total = cards.length;
                    if (!total) return;
                    const prevIndex = (currentIndex - 1 + total) % total;
                    const nextIndex = (currentIndex + 1) % total;
                    cards.forEach((card, index) => {
                        card.classList.remove('is-active', 'is-prev', 'is-next', 'is-off');
                        if (index === currentIndex) {
                            card.classList.add('is-active');
                        } else if (index === prevIndex) {
                            card.classList.add('is-prev');
                        } else if (index === nextIndex) {
                            card.classList.add('is-next');
                        } else {
                            card.classList.add('is-off');
                        }
                    });
                }

                function updateTransform() {
                    const total = cards.length;
                    if (!total) return;
                    const card = cards[currentIndex];
                    const container = shell || moduleCarousel;
                    const containerWidth = container.clientWidth;
                    const shellStyles = shell ? window.getComputedStyle(shell) : null;
                    const paddingLeft = shellStyles ? parseFloat(shellStyles.paddingLeft || '0') : 0;
                    const paddingRight = shellStyles ? parseFloat(shellStyles.paddingRight || '0') : 0;
                    const contentWidth = containerWidth - paddingLeft - paddingRight;
                    const targetCenter = (contentWidth > 0 ? contentWidth : containerWidth) / 2;
                    const cardCenter = card.offsetLeft + (card.offsetWidth / 2);
                    const offset = targetCenter - cardCenter;
                    moduleCarousel.style.transform = `translateX(${offset}px)`;
                    applyModuleClasses();
                }

                function startModuleCarousel() {
                    if (!cards.length) return;
                    updateTransform();
                    if (!reduceMotion && !carouselTimer) {
                        carouselTimer = setInterval(() => {
                            currentIndex = (currentIndex + 1) % cards.length;
                            updateTransform();
                        }, 3200);
                    }
                }

                function stopModuleCarousel() {
                    if (carouselTimer) {
                        clearInterval(carouselTimer);
                        carouselTimer = null;
                    }
                    moduleCarousel.style.removeProperty('transform');
                    cards.forEach((card) => card.classList.remove('is-active', 'is-prev', 'is-next', 'is-off'));
                }

                function updateModuleCarousel() {
                    const isDark = document.documentElement.classList.contains('dark');
                    const shouldRun = isDark && mobileQuery.matches;
                    if (shouldRun) {
                        startModuleCarousel();
                    } else {
                        stopModuleCarousel();
                    }
                }

                updateModuleCarousel();
                window.addEventListener('resize', updateModuleCarousel);
                if (mobileQuery.addEventListener) {
                    mobileQuery.addEventListener('change', updateModuleCarousel);
                }

                const modeObserver = new MutationObserver(updateModuleCarousel);
                modeObserver.observe(document.documentElement, {attributes: true, attributeFilter: ['class']});
            }
        });
    </script>
</x-layout>

