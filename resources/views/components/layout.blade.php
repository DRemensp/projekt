<!DOCTYPE html>
<html lang="de" class="">
<head>
    <meta charset="utf-8">
    <title>CampusOlympiade</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/navbar.js', 'resources/js/laufzettel-search.js', 'resources/js/teacher-scores.js', 'resources/js/admin-carousel.js'])

    <script>
        // Darkmode initialisierung - VOR dem Rendering (verhindert Flackern)
        function initDarkMode() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else if (prefersDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        initDarkMode();
    </script>
</head>

{{-- HIER: Globaler Alpine State für Theme und Modal --}}
<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
      data-auth="{{ auth()->check() ? '1' : '0' }}"
      data-roles="{{ auth()->check() ? auth()->user()->getRoleNames()->implode(',') : '' }}"
      x-data="{
          darkMode: document.documentElement.classList.contains('dark'),
          heartModalOpen: false,
          mobileMoreOpen: false,
          toggleTheme() {
              this.darkMode = !this.darkMode;
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
                  localStorage.setItem('theme', 'dark');
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.setItem('theme', 'light');
              }
              // Smooth scroll to top
              window.scrollTo({ top: 0, behavior: 'smooth' });
          }
      }"
      @keydown.escape.window="heartModalOpen = false; mobileMoreOpen = false">

<nav id="navbar"
     class="fixed md:fixed top-0 w-full z-50 bg-transparent dark:bg-transparent shadow-none md:bg-white md:dark:bg-gray-800 md:shadow-sm transition-colors duration-300">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a id="mobileBrandLink" href="{{ url('/') }}"
                   class="group flex items-center space-x-3 hover:opacity-80 transition-opacity duration-200">
                    <div id="mobileBrandLogoWrap"
                         class="w-11 h-11 border border-2 border-blue-400 dark:border-blue-500 rounded-full flex items-center justify-center transition-colors duration-200 overflow-hidden">
                        <img src="{{ asset('img.png')}}" alt="CampusOlympiade Logo" class="w-12 h-12 object-cover">
                    </div>
                    <span id="mobileBrandText"
                          class="font-bold text-xl text-gray-800 dark:text-gray-100 transition-colors duration-200 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                        Campus<span class="text-blue-600 dark:text-blue-400">Olympiade</span>
                    </span>
                </a>
            </div>

            <div class="hidden xl:flex items-center space-x-6">
                <a href="{{ url('/') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('/') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">🏠
                    Start</a>
                <a href="{{ url('/ranking') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('ranking') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">🏆
                    Ranking</a>
                <a href="{{ url('/laufzettel') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('laufzettel*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">📋
                    Laufzettel</a>
                <a href="{{ url('/archive') }}"
                   class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('archive*') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">📚
                    Archiv</a>

                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/teacher') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('teacher') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">📊
                            Lehrer</a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ url('/admin') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('admin') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">⚙️
                            Admin</a>
                    @endif

                    @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                        <a href="{{ url('/dashboard') }}"
                           class="w-32 py-3 rounded text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-105 transition-all duration-200 text-lg font-medium text-center {{ Request::is('dashboard') ? 'bg-blue-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}">👤
                            Dashboard</a>
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

            <button id="mobileMenuButton"
                    class="hidden md:block xl:hidden p-2 rounded text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobileMenu"
         class="hidden xl:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700 transition-colors duration-300">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ url('/') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">🏠
                Start</a>
            <a href="{{ url('/ranking') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">🏆
                Ranking</a>
            <a href="{{ url('/laufzettel') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">📋
                Laufzettel</a>
            <a href="{{ url('/archive') }}"
               class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">📚
                Archive</a>

            @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/teacher') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">📊
                        Lehrer</a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">⚙️
                        Admin</a>
                @endif
                @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/dashboard') }}"
                       class="block px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 rounded transition-all duration-200">👤
                        Dashboard</a>
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

{{-- ÄNDERUNG: pt-8 entfernt, damit der Hintergrund ganz oben anschließt --}}
<main class="relative">
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none hidden dark:block" aria-hidden="true">
        <div class="parallax-layer absolute inset-0" data-speed="0.12">
            <div class="aurora-sky absolute inset-0"></div>
        </div>
        <div class="parallax-layer absolute inset-0" data-speed="0.22">
            <div class="aurora-grid absolute inset-0"></div>
        </div>
        <div class="parallax-layer absolute inset-0" data-speed="0.35">
            <div class="hero-orb absolute rounded-full blur-[40px] opacity-60"
                 style="width: 320px; height: 320px; top: -80px; left: 8%; background: rgba(45, 212, 191, 0.35);"></div>
            <div class="hero-orb absolute rounded-full blur-[40px] opacity-60"
                 style="width: 380px; height: 380px; top: 20%; right: 5%; background: rgba(96, 165, 250, 0.35); animation-delay: 0.5s;"></div>
            <div class="hero-orb absolute rounded-full blur-[40px] opacity-60"
                 style="width: 260px; height: 260px; bottom: -60px; left: 40%; background: rgba(245, 158, 11, 0.35); animation-delay: 1s;"></div>

            <div class="glow-dot"
                 style="width: 8px; height: 8px; top: 15%; left: 25%; background: #2dd4bf; animation-delay: 0s;"></div>
            <div class="glow-dot"
                 style="width: 6px; height: 6px; top: 35%; left: 75%; background: #60a5fa; animation-delay: 1s;"></div>
            <div class="glow-dot"
                 style="width: 10px; height: 10px; top: 55%; left: 15%; background: #f59e0b; animation-delay: 2s;"></div>
            <div class="glow-dot"
                 style="width: 7px; height: 7px; top: 75%; left: 85%; background: #fb7185; animation-delay: 3s;"></div>
            <div class="glow-dot"
                 style="width: 8px; height: 8px; top: 25%; left: 50%; background: #2dd4bf; animation-delay: 1.5s;"></div>
            <div class="glow-dot"
                 style="width: 6px; height: 6px; top: 45%; left: 30%; background: #60a5fa; animation-delay: 2.5s;"></div>
            <div class="glow-dot"
                 style="width: 9px; height: 9px; top: 65%; left: 60%; background: #f59e0b; animation-delay: 0.5s;"></div>
            <div class="glow-dot"
                 style="width: 10px; height: 10px; top: 85%; left: 40%; background: #2dd4bf; animation-delay: 3.5s;"></div>
            <div class="glow-dot"
                 style="width: 7px; height: 7px; top: 10%; left: 90%; background: #60a5fa; animation-delay: 4s;"></div>
            <div class="glow-dot"
                 style="width: 8px; height: 8px; top: 50%; left: 10%; background: #fb7185; animation-delay: 1.8s;"></div>
            <div class="glow-dot"
                 style="width: 6px; height: 6px; top: 20%; left: 65%; background: #2dd4bf; animation-delay: 0.8s;"></div>
            <div class="glow-dot"
                 style="width: 9px; height: 9px; top: 40%; left: 85%; background: #f59e0b; animation-delay: 2.2s;"></div>
            <div class="glow-dot"
                 style="width: 7px; height: 7px; top: 60%; left: 20%; background: #60a5fa; animation-delay: 3.8s;"></div>
            <div class="glow-dot"
                 style="width: 8px; height: 8px; top: 80%; left: 70%; background: #fb7185; animation-delay: 1.2s;"></div>
            <div class="glow-dot"
                 style="width: 10px; height: 10px; top: 30%; left: 5%; background: #f59e0b; animation-delay: 2.8s;"></div>
        </div>
    </div>

    {{-- ÄNDERUNG: Cookie Include hier entfernt und nach unten verschoben --}}
    <div class="relative z-10 home-theme">
        {{ $slot }}
    </div>
</main>

<nav
    class="fixed bottom-0 inset-x-0 z-40 border-t border-gray-200 bg-white/95 backdrop-blur dark:border-gray-700 dark:bg-gray-900/95 md:hidden pb-[env(safe-area-inset-bottom)]">
    <div class="mx-auto max-w-lg px-2 py-2">
        <div class="grid grid-cols-5 items-end gap-1 text-[11px]">
            <a href="{{ url('/') }}"
               class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300 {{ Request::is('/') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                <span class="text-base">🏠</span>
                <span>Start</span>
            </a>

            <a href="{{ url('/ranking') }}"
               class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300 {{ Request::is('ranking') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                <span class="text-base">🏆</span>
                <span>Ranking</span>
            </a>

            <a href="{{ url('/laufzettel') }}" class="flex flex-col items-center justify-center -mt-6">
                <span
                    class="grid h-12 w-12 place-items-center rounded-full bg-blue-600 text-white shadow-lg ring-4 ring-white dark:ring-gray-900 text-lg {{ Request::is('laufzettel*') ? 'bg-blue-700' : '' }}">📋</span>
                <span class="mt-1 font-semibold text-blue-600 dark:text-blue-400">Laufzettel</span>
            </a>

            @guest
                <a href="{{ url('/archive') }}"
                   class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300 {{ Request::is('archive*') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                    <span class="text-base">📚</span>
                    <span>Archiv</span>
                </a>
            @endguest
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}"
                       class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300 {{ Request::is('admin') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                        <span class="text-base">⚙️</span>
                        <span>Admin</span>
                    </a>
                @elseif(auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/teacher') }}"
                       class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300 {{ Request::is('teacher') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                        <span class="text-base">📊</span>
                        <span>Teacher</span>
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                       class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300 {{ Request::is('dashboard') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                        <span class="text-base">👤</span>
                        <span>Dashboard</span>
                    </a>
                @endif
            @endauth

            <button type="button" @click="mobileMoreOpen = !mobileMoreOpen"
                    class="flex flex-col items-center justify-center rounded-lg px-2 py-1.5 text-gray-600 dark:text-gray-300">
                <span class="text-base">☰</span>
                <span>Mehr</span>
            </button>
        </div>
    </div>
</nav>

<div x-show="mobileMoreOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 md:hidden"
     @click="mobileMoreOpen = false" style="display: none;"></div>
<div x-show="mobileMoreOpen" x-transition class="fixed inset-x-0 bottom-[70px] z-50 px-3 md:hidden"
     style="display: none;">
    <div
        class="mx-auto max-w-lg rounded-2xl border border-gray-200 bg-white/95 p-3 shadow-2xl backdrop-blur dark:border-gray-700 dark:bg-gray-900/95">
        <div class="grid grid-cols-2 gap-2 text-sm">
            <a href="{{ url('/') }}" @click="mobileMoreOpen = false"
               class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">🏠
                Start</a>
            <a href="{{ url('/ranking') }}" @click="mobileMoreOpen = false"
               class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">🏆
                Ranking</a>
            <a href="{{ url('/laufzettel') }}" @click="mobileMoreOpen = false"
               class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">📋
                Laufzettel</a>
            <a href="{{ url('/archive') }}" @click="mobileMoreOpen = false"
               class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">📚
                Archiv</a>

            @auth
                @if(auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/teacher') }}" @click="mobileMoreOpen = false"
                       class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">📊
                        Lehrer</a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ url('/admin') }}" @click="mobileMoreOpen = false"
                       class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">⚙️
                        Admin</a>
                @endif
                @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('teacher'))
                    <a href="{{ url('/dashboard') }}" @click="mobileMoreOpen = false"
                       class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">👤
                        Dashboard</a>
                @endif
                <a href="{{ route('profile') }}" @click="mobileMoreOpen = false"
                   class="rounded-lg px-3 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">🧾
                    Profil</a>
            @else
                <div class="col-span-2 pt-1" @click="mobileMoreOpen = false">
                    @include('components.login-button')
                </div>
            @endauth
        </div>
        <div class="mt-3 border-t border-gray-200 pt-3 dark:border-gray-700">
            @auth
                <livewire:logout-button/>
            @endauth
        </div>
    </div>
</div>

<footer
    class="bg-gray-800 dark:bg-gray-950 text-white pt-6 pb-[calc(6.5rem+env(safe-area-inset-bottom))] md:py-6 duration-300">
    <div class="container mx-auto px-4 text-center">
        <div class="flex justify-center items-center gap-6 mb-4">
            {{-- Footer Button: Öffnet das Modal via Alpine --}}
            <button @click="heartModalOpen = true"
                    class="group relative flex items-center gap-3 rounded-full px-3 py-2 text-left transition duration-200 ease-out hover:-translate-y-0.5 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-300/70 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800 bg-gradient-to-r from-sky-500/30 via-blue-500/20 to-cyan-400/30 dark:from-blue-500/40 dark:via-sky-500/20 dark:to-cyan-500/30 ring-1 ring-white/10 shadow-[0_12px_24px_rgba(15,23,42,0.28)] overflow-hidden before:content-[''] before:absolute before:inset-0 before:translate-x-[-120%] before:bg-gradient-to-r before:from-transparent before:via-white/40 before:to-transparent before:transition before:duration-700 group-hover:before:translate-x-[120%]">
                <div
                    class="grid h-10 w-10 place-items-center rounded-full bg-blue-600 text-xl shadow-md transition duration-200 group-hover:rotate-[-6deg] group-hover:scale-105 group-hover:bg-blue-700 dark:bg-blue-500 dark:group-hover:bg-blue-600">
                    ❤️
                </div>
                <span class="font-semibold text-white/90 transition-colors duration-200 group-hover:text-white">CampusOlympiade</span>
            </button>

            {{-- Darkmode Toggle: Nutzt Alpine Funktion toggleTheme() --}}
            <button @click="toggleTheme()"
                    class="group relative flex items-center gap-3 rounded-full px-4 py-2 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-300/70 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800 bg-gradient-to-r from-gray-700 via-gray-600 to-gray-700 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 ring-1 ring-white/10 shadow-lg overflow-hidden active:scale-95">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-700"></div>
                <div
                    class="relative grid h-8 w-8 place-items-center rounded-full bg-gradient-to-br from-yellow-300 to-orange-400 dark:from-blue-400 dark:to-indigo-600 shadow-md transition-all duration-300 group-hover:rotate-180 group-hover:scale-110">
                    <svg x-show="darkMode" class="w-5 h-5 text-white transition-all duration-300 group-hover:scale-125"
                         fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path fill-rule="evenodd"
                              d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5 text-white transition-all duration-300 group-hover:scale-125"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </div>
                <span
                    class="relative text-sm font-semibold text-white/90 transition-all duration-200 group-hover:text-white group-hover:scale-105"
                    x-text="darkMode ? 'Light' : 'Dark'"></span>
            </button>
        </div>
        <div class="text-sm text-gray-400 dark:text-gray-500 transition-colors duration-200">
            <p>© {{ date('Y') }} CampusOlympiade. Alle Rechte vorbehalten.</p>
            <div class="mt-3 flex flex-wrap items-center justify-center gap-3 text-xs">
                <a href="{{ route('legal.privacy') }}"
                   class="hover:text-blue-300 dark:hover:text-blue-400 transition-colors duration-200">Datenschutz</a>
                <a href="{{ route('legal.cookies') }}"
                   class="hover:text-blue-300 dark:hover:text-blue-400 transition-colors duration-200">Cookie-Richtlinie</a>
                <a href="{{ route('legal.terms') }}"
                   class="hover:text-blue-300 dark:hover:text-blue-400 transition-colors duration-200">Nutzungsbedingungen</a>
                <a href="{{ route('legal.imprint') }}"
                   class="hover:text-blue-300 dark:hover:text-blue-400 transition-colors duration-200">Impressum</a>
            </div>
            <div class="mt-3">
                <button id="openCookiePreferences" type="button"
                        class="inline-flex items-center rounded-md border border-gray-500/60 px-3 py-1.5 text-xs font-semibold text-gray-200 transition hover:border-blue-300 hover:text-blue-300 dark:text-gray-300 dark:hover:text-blue-300">
                    Cookie-Präferenzen ändern
                </button>
            </div>
        </div>
    </div>
</footer>

{{-- Pop-up Modal: Gesteuert durch Alpine (heartModalOpen) --}}
<div x-show="heartModalOpen"
     style="display: none;"
     class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div @click.outside="heartModalOpen = false"
         class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 relative transition-colors duration-300">
        <button @click="heartModalOpen = false"
                class="absolute top-2 right-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-xl">
            &times;
        </button>
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

<div id="adminBroadcastPopup" class="fixed inset-0 z-[9999] hidden relative" aria-labelledby="modal-title" role="dialog"
     aria-modal="true">
    <div class="fixed inset-0 bg-gray-950/80 backdrop-blur transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <div
                class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg ring-1 ring-white/10">

                <div class="px-6 py-8 sm:p-10">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                        </div>

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Neue Ankündigung
                            </h3>
                            <div class="mt-4">
                                <div
                                    class="relative rounded-lg bg-gray-50 dark:bg-gray-800/50 p-4 border border-gray-100 dark:border-gray-700">
                                    <p class="text-base text-gray-700 dark:text-gray-300 font-medium leading-relaxed"
                                       data-admin-broadcast-message>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-10 border-t border-gray-100 dark:border-gray-800">
                    <button type="button"
                            data-admin-broadcast-close
                            disabled
                            class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-8 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:w-auto disabled:opacity-50 disabled:grayscale transition-all duration-200">
                        Gelesen <span data-admin-broadcast-timer class="ml-1">(5)</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openCookiePreferencesButton = document.getElementById('openCookiePreferences');
        if (openCookiePreferencesButton) {
            openCookiePreferencesButton.addEventListener('click', function () {
                document.cookie = '{{ config('cookie-consent.cookie_name') }}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
                window.location.reload();
            });
        }

        // Parallax Effect (Reines JS, da performant)
        const parallaxLayers = document.querySelectorAll('.parallax-layer');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (parallaxLayers.length && !reduceMotion) {
            let latestY = window.scrollY || window.pageYOffset;
            let ticking = false;

            function updateParallax() {
                ticking = false;
                const scrollY = latestY;
                parallaxLayers.forEach((layer) => {
                    const speed = parseFloat(layer.dataset.speed || '0');
                    const offset = scrollY * speed;
                    layer.style.transform = `translate3d(0, ${offset}px, 0)`;
                });
            }

            function onScroll() {
                latestY = window.scrollY || window.pageYOffset;
                if (!ticking) {
                    window.requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            updateParallax();
            window.addEventListener('scroll', onScroll, {passive: true});
        }
    });
</script>

{{-- ÄNDERUNG: Cookie Include hierhin verschoben --}}
@include('cookie-consent::index')

@livewireScripts

</body>
</html>
