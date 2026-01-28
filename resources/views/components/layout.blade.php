<!DOCTYPE html>
<html lang="de" class="">
<head>
    <meta charset="utf-8">
    <title>CampusOlympiade</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/js/laufzettel-search.js', 'resources/js/teacher-scores.js', 'resources/js/admin-carousel.js'])

    <script>
        // Darkmode initialisierung - VOR dem Rendering
        function initDarkMode() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        initDarkMode();
    </script>
</head>

<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

<nav id="navbar" class="fixed top-0 w-full z-50 bg-white dark:bg-gray-800 shadow-sm transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="{{ url('/') }}"
                   class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200">
                    <div
                        class="w-11 h-11 border border-2 border-blue-400 dark:border-blue-500 rounded-full flex items-center justify-center hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200 overflow-hidden">
                        <img src="{{ asset('img.png')}}" alt="CampusOlympiade Logo" class="w-12 h-12 object-cover">
                    </div>
                    <span class="font-bold text-xl text-gray-800 dark:text-gray-100">
                        Campus<span class="text-blue-600 dark:text-blue-400">Olympiade</span>
                    </span>
                </a>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                <a href="{{ url('/') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('/') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                    🏠 Start
                </a>

                <a href="{{ url('/ranking') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('ranking') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                    🏆 Ranking
                </a>

                <a href="{{ url('/laufzettel') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('laufzettel*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                    📋 Laufzettel
                </a>

                <a href="{{ url('/archive') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('archive*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                    📚 Archiv
                </a>

                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/teacher') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('teacher') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            📊 Lehrer
                        </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ url('/admin') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('admin') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
                            ⚙️ Admin
                        </a>
                    @endif

                    @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/dashboard') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('dashboard') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">
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
                    class="lg:hidden p-2 rounded text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700 transition-colors duration-300">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ url('/') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >🏠 Start</a>
            <a href="{{ url('/ranking') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >🏆 Ranking</a>
            <a href="{{ url('/laufzettel') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >📋 Laufzettel</a>
            <a href="{{ url('/archive') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
            >📚 Archive</a>


            @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/teacher') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
                    >📊 Lehrer</a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
                    >⚙️ Admin</a>
                @endif
                @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/dashboard') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200"
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

<main class="pt-16">
    {{ $slot }}
    @include('cookie-consent::index')
</main>

<footer class="bg-gray-800 dark:bg-gray-950 text-white py-6 duration-300">
    <div class="container mx-auto px-4 text-center">
        <div class="flex justify-center items-center gap-6 mb-4">
            <button id="footerButton" class="group relative flex items-center gap-3 rounded-full px-3 py-2 text-left transition duration-200 ease-out hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-300/70 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800 bg-gradient-to-r from-sky-500/30 via-blue-500/20 to-cyan-400/30 dark:from-blue-500/40 dark:via-sky-500/20 dark:to-cyan-500/30 ring-1 ring-white/10 shadow-[0_12px_24px_rgba(15,23,42,0.28)] overflow-hidden before:content-[''] before:absolute before:inset-0 before:translate-x-[-120%] before:bg-gradient-to-r before:from-transparent before:via-white/40 before:to-transparent before:transition before:duration-700 group-hover:before:translate-x-[120%]">
                <div class="grid h-10 w-10 place-items-center rounded-full bg-blue-600 text-xl shadow-md transition duration-200 group-hover:rotate-[-6deg] group-hover:scale-105 group-hover:bg-blue-700 dark:bg-blue-500 dark:group-hover:bg-blue-600">
                    ❤️
                </div>
                <span class="font-semibold text-white/90 transition-colors duration-200 group-hover:text-white">CampusOlympiade</span>
            </button>

            <!-- Darkmode Toggle -->
            <button id="darkModeToggle" class="group relative flex items-center gap-3 rounded-full px-4 py-2 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-300/70 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 ring-1 ring-white/10 shadow-lg overflow-hidden active:scale-95">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-700"></div>
                <div class="relative grid h-8 w-8 place-items-center rounded-full bg-gradient-to-br from-yellow-300 to-orange-400 dark:from-blue-400 dark:to-indigo-600 shadow-md transition-all duration-300 group-hover:rotate-180 group-hover:scale-110">
                    <svg id="sunIcon" class="w-5 h-5 text-white hidden dark:block transition-all duration-300 group-hover:scale-125" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                    </svg>
                    <svg id="moonIcon" class="w-5 h-5 text-white block dark:hidden transition-all duration-300 group-hover:scale-125" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </div>
                <span class="relative text-sm font-semibold text-white/90 transition-all duration-200 group-hover:text-white group-hover:scale-105" id="darkModeText">Dark</span>
            </button>
        </div>
        <div class="text-sm text-gray-400 dark:text-gray-500 hover:text-gray-300 dark:hover:text-gray-400 transition-colors duration-200">
            <a href="https://youtu.be/xvFZjo5PgG0?si=f-8cYCSRPThugYsm"
               class="hover:text-blue-300 dark:hover:text-blue-400 transition-colors duration-200">Probleme? Click hier um mit dem Admin zu schreiben <br> © {{ date('Y') }} CampusOlympiade. Alle Rechte vorbehalten.</a>
        </div>
    </div>
</footer>

<!-- Pop-up Modal -->
<div id="heartModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 relative transition-colors duration-300">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-xl">&times;</button>
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
        // Darkmode nach dem Laden erneut prüfen
        initDarkMode();

        // Darkmode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeText = document.getElementById('darkModeText');
        const html = document.documentElement;

        function updateDarkModeText() {
            if (html.classList.contains('dark')) {
                darkModeText.textContent = 'Light';
            } else {
                darkModeText.textContent = 'Dark';
            }
        }

        darkModeToggle.addEventListener('click', function() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
            updateDarkModeText();

            // Scroll zurück an die Spitze mit smooth animation
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initial text update
        updateDarkModeText();

        // Heart Modal
        const footerButton = document.getElementById('footerButton');
        const heartModal = document.getElementById('heartModal');
        const closeModal = document.getElementById('closeModal');

        footerButton.addEventListener('click', function() {
            heartModal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', function() {
            heartModal.classList.add('hidden');
        });

        heartModal.addEventListener('click', function(e) {
            if (e.target === heartModal) {
                heartModal.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !heartModal.classList.contains('hidden')) {
                heartModal.classList.add('hidden');
            }
        });
    });
</script>

</body>
</html>

