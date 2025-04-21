{{-- resources/views/layout.blade.php --}}
    <!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>CampusOlympiade</title>

    {{-- Favicon-Beispiel --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    {{-- Binde Deine CSS-/JS-Dateien ein (z. B. via Vite) --}}
    @vite([
               'resources/css/app.css',
               'resources/js/app.js',
               'resources/js/navbar.js',
               'resources/js/ranking-search.js'
           ])
</head>


<body class="antialiased">

<nav
    id="navbar"
    class="fixed w-full z-50 transition-all duration-300"
    style="
        background-image: url('#'); {{-- Ggf. Bildpfad hier dynamisch setzen oder entfernen --}}
        background-size: cover;
        background-position: center;
        background-blend-mode: overlay;
    "
>
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center mr-6"> {{-- mr-6 bleibt von vorheriger Änderung --}}
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">CO</span>
                    </div>
                    <span class="font-bold text-lg text-gray-800">
                        Campus<span class="text-blue-600">Olympiade</span>
                    </span>
                </a>
            </div>

            {{-- HIER: space-x-6 zu space-x-4 geändert --}}
            <div class="hidden md:flex items-center space-x-4">
                <a
                    href="{{ url('/') }}"
                    class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('/') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Start</span>
                </a>

                <a
                    href="{{ url('/ranking') }}"
                    class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('ranking') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="7"></circle>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                    </svg>
                    <span>Ranking</span>
                </a>

                <a
                    href="{{ url('/teacher') }}"
                    class="flex items-center space-x-1 px-3 py-2 rounded-md transition-colors duration-200
                           {{ Request::is('teacher') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}" {{-- Korrigierter Request::is --}}
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    <span>Teacher</span>
                </a>

                <a
                    href="{{ url('/admin') }}"
                    class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('admin') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Admin</span>
                </a>

                {{-- Falls Gast: Login-Button --}}
                @guest
                    @include('components.login-button')
                @endguest

                {{-- Falls Auth: Logout-Button --}}
                @auth
                    <livewire:logout-button/>
                @endauth

            </div>

            <button
                id="mobileMenuButton"
                class="md:hidden flex items-center p-2 rounded-md text-gray-700 hover:bg-blue-50
                       focus:outline-none"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <div id="mobileMenu" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white shadow-lg">
            <a
                href="{{ url('/') }}"
                class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('/') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Start</span>
            </a>

            <a
                href="{{ url('/ranking') }}"
                class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('ranking') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="7"></circle>
                    <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                <span>Ranking</span>
            </a>

            <a
                href="{{ url('/teacher') }}"
                class="flex items-center space-x-1 px-3 py-2 rounded-md transition-colors duration-200
                           {{ Request::is('teacher') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}" {{-- Korrigierter Request::is --}}
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
                <span>Teacher</span>
            </a>

            <a
                href="{{ url('/admin') }}"
                class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('admin') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Admin</span>
            </a>

            {{-- Falls Gast: Login-Button --}}
            @guest
                @include('components.login-button')
            @endguest

            {{-- Falls Auth: Logout-Button --}}
            @auth
                <livewire:logout-button/>
            @endauth

        </div>
    </div>
</nav>

{{-- Inhalt Deiner Seite --}}
<div class="pt-16">
    {{-- Haupt-Slot für den Seiteninhalt --}}
    {{ $slot }}
</div>

</body>
</html>
