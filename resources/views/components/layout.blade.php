<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>CampusOlympiade</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/js/laufzettel-search.js', 'resources/js/teacher-scores.js', 'resources/js/admin-carousel.js'])

    <script>
        // Dark Mode Initialisierung - VOR dem Laden der Seite
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

<nav id="navbar" class="fixed w-full z-50 bg-white dark:bg-gray-900 shadow-sm transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="{{ url('/') }}"
                   class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200">
                    <div
                        class="w-11 h-11 border border-2 border-blue-400 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-200 overflow-hidden">
                        <img src="{{ asset('img.png')}}" alt="CampusOlympiade Logo" class="w-12 h-12 object-cover">
                    </div>
                    <span class="font-bold text-xl text-gray-800 dark:text-gray-100 transition-colors duration-300">
                        Campus<span class="text-blue-600 dark:text-blue-400">Olympiade</span>
                    </span>
                </a>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                <a href="{{ url('/') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('/') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                    🏠 Start
                </a>

                <a href="{{ url('/ranking') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('ranking') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                    🏆 Ranking
                </a>

                <a href="{{ url('/laufzettel') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('laufzettel*') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                    📋 Laufzettel
                </a>

                <a href="{{ url('/archive') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('archive*') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                    📚 Archiv
                </a>

                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/teacher') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('teacher') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                            📊 Lehrer
                        </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ url('/admin') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('admin') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                            ⚙️ Admin
                        </a>
                    @endif

                    @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/dashboard') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('dashboard') ? 'bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-blue-400' : '' }}">
                            👤 Dashboard
                        </a>
                    @endif
                @endauth

                @guest
                    <div class="w-32">
                        @include('components.login-button')
                    </div>
                @endguest

                @auth
                    <div class="w-32">
                        <livewire:logout-button/>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <button id="mobileMenuButton"
                    class="lg:hidden p-2 rounded text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ url('/') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >🏠 Start</a>
            <a href="{{ url('/ranking') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >🏆 Ranking</a>
            <a href="{{ url('/laufzettel') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >📋 Laufzettel</a>
            <a href="{{ url('/archive') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >📚 Archive</a>


            @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/teacher') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
                    >📊 Lehrer</a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
                    >⚙️ Admin</a>
                @endif
                @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/dashboard') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
                    >👤 Dashboard</a>
                @endif
            @endauth

            @guest
                <div class="px-3 py-2">
                    @include('components.login-button')
                </div>
            @endguest

            @auth
                <div class="px-3 py-2">
                    <livewire:logout-button/>
                </div>
            @endauth
        </div>
    </div>
</nav>

<main class="pt-16 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    {{ $slot }}
    @include('cookie-consent::index')
</main>

<footer class="bg-gray-800 dark:bg-gray-950 text-white py-8 duration-300 transition-colors">
    <div class="container mx-auto px-4">
        <!-- Main Footer Content -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6 mb-6">

            <!-- Dark Mode Toggle - Spielerisches Design -->
            <div class="flex flex-col items-center lg:items-start space-y-2">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold text-yellow-400 bg-yellow-900/30 px-2 py-0.5 rounded-full border border-yellow-600/50 animate-pulse">
                        🧪 BETA
                    </span>
                    <span class="text-xs text-gray-400">Experimentell</span>
                </div>

                <button id="darkModeToggle"
                        class="group relative flex items-center gap-3 px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300"
                        aria-label="Dark Mode umschalten">

                    <!-- Moon Icon (Light Mode) -->
                    <div id="moonIcon" class="flex items-center gap-2">
                        <div class="relative">
                            <svg class="w-6 h-6 text-yellow-300 group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                            </svg>
                            <div class="absolute -top-1 -right-1 w-2 h-2 bg-yellow-400 rounded-full animate-ping"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-white">Nachtmodus</span>
                            <span class="text-xs text-indigo-200">🌙 Aktivieren</span>
                        </div>
                    </div>

                    <!-- Sun Icon (Dark Mode) -->
                    <div id="sunIcon" class="hidden items-center gap-2">
                        <div class="relative">
                            <svg class="w-6 h-6 text-yellow-300 group-hover:rotate-180 transition-transform duration-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="absolute -top-1 -right-1 w-2 h-2 bg-orange-400 rounded-full animate-ping"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-white">Tagmodus</span>
                            <span class="text-xs text-purple-200">☀️ Aktivieren</span>
                        </div>
                    </div>

                    <!-- Decorative Trophy -->
                    <span class="text-xl group-hover:scale-110 transition-transform duration-300">🏆</span>
                </button>
            </div>

            <!-- Center Content -->
            <div class="flex flex-col items-center text-center lg:flex-1">
                <button id="footerButton" class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200 cursor-pointer mb-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-200 text-xl">
                        ❤️
                    </div>
                    <span class="font-semibold hover:text-blue-300 transition-colors duration-200">CampusOlympiade</span>
                </button>

                <div class="text-sm text-gray-400 hover:text-gray-300 transition-colors duration-200">
                    <a href="https://youtu.be/xvFZjo5PgG0?si=f-8cYCSRPThugYsm"
                       class="hover:text-blue-300 transition-colors duration-200">
                        Probleme? Click hier um mit dem Admin zu schreiben
                    </a>
                </div>
            </div>

            <!-- Right Side - Placeholder for symmetry on desktop -->
            <div class="hidden lg:block lg:w-64"></div>
        </div>

        <!-- Copyright -->
        <div class="text-center text-xs text-gray-500 pt-4 border-t border-gray-700">
            © {{ date('Y') }} CampusOlympiade. Alle Rechte vorbehalten.
        </div>
    </div>
</footer>

<!-- Pop-up Modal -->
<div id="heartModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 relative transition-colors duration-300">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-xl transition-colors duration-200">&times;</button>
        <div class="text-center">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Dankeschön ❤️</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                Mein herzlicher Dank gilt Herrn Haist für die Möglichkeit, dieses Projekt zu entwickeln.
                Die Arbeit daran hat mir unerwartet viel Freude bereitet und war eine tolle Erfahrung.
                Als Schüler der 2BKI2/2 2025 war dies ein wunderbarer Abschluss meiner Schulzeit hier.
                Ich hoffe, dass die CampusOlympiade von den Schulen aktiv genutzt wird und allen Beteiligten gefällt.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const footerButton = document.getElementById('footerButton');
        const heartModal = document.getElementById('heartModal');
        const closeModal = document.getElementById('closeModal');

        footerButton.addEventListener('click', function() {
            heartModal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', function() {
            heartModal.classList.add('hidden');
        });

        // Schließen beim Klick außerhalb des Modals
        heartModal.addEventListener('click', function(e) {
            if (e.target === heartModal) {
                heartModal.classList.add('hidden');
            }
        });

        // Schließen mit Escape-Taste
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !heartModal.classList.contains('hidden')) {
                heartModal.classList.add('hidden');
            }
        });
    });
</script>

@livewireScripts
</body>
</html>
