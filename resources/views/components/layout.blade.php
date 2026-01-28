<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>CampusOlympiade</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/js/laufzettel-search.js', 'resources/js/teacher-scores.js', 'resources/js/admin-carousel.js'])
</head>

<body class="antialiased">

<nav id="navbar" class="fixed w-full z-50 bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="{{ url('/') }}"
                   class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200">
                    <div
                        class="w-11 h-11 border border-2 border-blue-400 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-200 overflow-hidden">
                        <img src="{{ asset('img.png')}}" alt="CampusOlympiade Logo" class="w-12 h-12 object-cover">
                    </div>
                    <span class="font-bold text-xl text-gray-800">
                        Campus<span class="text-blue-600">Olympiade</span>
                    </span>
                </a>
            </div>

            <div class="hidden lg:flex items-center space-x-6">
                <a href="{{ url('/') }}"
                   class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('/') ? 'bg-blue-100 text-blue-600' : '' }}">
                    🏠 Start
                </a>

                <a href="{{ url('/ranking') }}"
                   class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('ranking') ? 'bg-blue-100 text-blue-600' : '' }}">
                    🏆 Ranking
                </a>

                <a href="{{ url('/laufzettel') }}"
                   class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('laufzettel*') ? 'bg-blue-100 text-blue-600' : '' }}">
                    📋 Laufzettel
                </a>

                <a href="{{ url('/archive') }}"
                   class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('archive*') ? 'bg-blue-100 text-blue-600' : '' }}">
                    📚 Archiv
                </a>

                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/teacher') }}"
                           class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('teacher') ? 'bg-blue-100 text-blue-600' : '' }}">
                            📊 Lehrer
                        </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ url('/admin') }}"
                           class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('admin') ? 'bg-blue-100 text-blue-600' : '' }}">
                            ⚙️ Admin
                        </a>
                    @endif

                    @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/dashboard') }}"
                           class="w-32 py-3 rounded text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('dashboard') ? 'bg-blue-100 text-blue-600' : '' }}">
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
                    class="lg:hidden p-2 rounded text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition-all duration-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white border-t">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ url('/') }}"
               class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
            >🏠 Start</a>
            <a href="{{ url('/ranking') }}"
               class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
            >🏆 Ranking</a>
            <a href="{{ url('/laufzettel') }}"
               class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
            >📋 Laufzettel</a>
            <a href="{{ url('/archive') }}"
               class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
            >📚 Archive</a>


            @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/teacher') }}"
                       class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
                    >📊 Lehrer</a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}"
                       class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
                    >⚙️ Admin</a>
                @endif
                @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/dashboard') }}"
                       class="block px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition-all duration-200"
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

<footer class="bg-gray-800 text-white py-6 duration-300">
    <div class="container mx-auto px-4 text-center">
        <div class="flex justify-center items-center mb-4">
            <button id="footerButton" class="flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200 cursor-pointer">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-200 text-xl">
                    ❤️
                </div>
                <span class="font-semibold hover:text-blue-300 transition-colors duration-200">CampusOlympiade</span>
            </button>
        </div>
        <div class="text-sm text-gray-400 hover:text-gray-300 transition-colors duration-200">
            <a href="https://youtu.be/xvFZjo5PgG0?si=f-8cYCSRPThugYsm"
               class="hover:text-blue-300 transition-colors duration-200">Probleme? Click hier um mit dem Admin zu schreiben <br> © {{ date('Y') }} CampusOlympiade. Alle Rechte vorbehalten.</a>
        </div>
    </div>
</footer>

<!-- Pop-up Modal -->
<div id="heartModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4 relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        <div class="text-center">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Dankeschön ❤️</h3>
            <p class="text-gray-600 leading-relaxed">
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

</body>
</html>
