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
           ])
</head>


<body class="antialiased">

<!-- Navigation -->
<nav
    id="navbar"
    class="fixed w-full z-50 transition-all duration-300"
    style="
        background-image: url('#');
        background-size: cover;
        background-position: center;
        background-blend-mode: overlay;
    "
>
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo-Bereich -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">CO</span>
                    </div>
                    <span class="font-bold text-lg text-gray-800">
                        Campus<span class="text-blue-600">Olympiade</span>
                    </span>
                </a>
            </div>

            <!-- Desktop-Menü (md: sichtbar, sonst ausgeblendet) -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Start -->
                <a
                    href="{{ url('/') }}"
                    class="flex items-center space-x-1 px-3 py-2 rounded-md transition-colors duration-200
                           {{ Request::is('/') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
                >
                    <!-- Beispiel-Icon Home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 9.75L12 4.5l9 5.25v9.75a2.25 2.25
                                 0 01-2.25 2.25H5.25A2.25 2.25 0
                                 013 19.5V9.75z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 22V12h6v10" />
                    </svg>
                    <span>Start</span>
                </a>

                <!-- Ranking -->
                <a
                    href="{{ url('/ranking') }}"
                    class="flex items-center space-x-1 px-3 py-2 rounded-md transition-colors duration-200
                           {{ Request::is('ranking') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
                >
                    <!-- Beispiel-Icon Award -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6l7.5 1.946a1 1 0
                                 01.727 1.292l-2.098 7.504 a1 1 0
                                 01-.968.74H6.84a1 1 0
                                 01-.968-.742L3.773 9.238 a1 1 0
                                 01.73-1.29L12 6z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 22h8m-8-4h8" />
                    </svg>
                    <span>Ranking</span>
                </a>

                <!-- Teacher -->
                <a
                    href="{{ url('/admin') }}"
                    class="flex items-center space-x-1 px-3 py-2 rounded-md transition-colors duration-200
                           {{ Request::is('admin') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
                >
                    <!-- Beispiel-Icon BookOpen -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 19c.34-.02.67-.04 1-.07
                                 3.06-.34 6 1 6 2.07m-7-2
                                 c-.33.03-.66.05-1.02.07
                                 -3.06.34-5.98-1-5.98-2.07
                                 v-13a2 2 0 012-2h8
                                 a2 2 0 012 2v13" />
                    </svg>
                    <span>Admin</span>
                </a>

                {{-- Falls Gast: Login-Button anzeigen --}}
                @guest
                    <!-- An der gewünschten Stelle in layout.blade.php -->
                    @include('components.login-button')

                @endguest

                {{-- Falls Auth: Logout-Button anzeigen --}}
                {{-- Falls Auth: Logout-Button --}}
                @auth
                    <livewire:logout-button/>
                @endauth

            </div>

            <!-- Mobile-Menü-Button (md: ausgeblendet, sm/xs: sichtbar) -->
            <button
                id="mobileMenuButton"
                class="md:hidden flex items-center p-2 rounded-md text-gray-700 hover:bg-blue-50
                       focus:outline-none"
            >
                <!-- Hamburger-Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile-Menü (per Default versteckt) -->
    <div id="mobileMenu" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white shadow-lg">
            <a
                href="{{ url('/') }}"
                class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('/') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
            >
                <!-- Home-Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 9.75L12 4.5l9 5.25v9.75a2.25
                             2.25 0 01-2.25 2.25H5.25A2.25
                             2.25 0 013 19.5V9.75z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 22V12h6v10" />
                </svg>
                <span>Start</span>
            </a>

            <a
                href="{{ url('/ranking') }}"
                class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('ranking') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
            >
                <!-- Award-Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6l7.5 1.946a1 1 0
                             01.727 1.292l-2.098 7.504 a1 1 0
                             01-.968.74H6.84a1 1 0
                             01-.968-.742L3.773 9.238
                             a1 1 0 01.73-1.29L12 6z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 22h8m-8-4h8" />
                </svg>
                <span>Ranking</span>
            </a>

            <a
                href="{{ url('/admin') }}"
                class="flex items-center space-x-2 px-3 py-2 rounded-md transition-colors duration-200
                       {{ Request::is('admin') ? 'bg-blue-100 text-blue-600' : 'hover:bg-blue-50 text-gray-700' }}"
            >
                <!-- BookOpen-Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 19c.34-.02.67-.04 1-.07
                             3.06-.34 6 1 6 2.07m-7-2
                             c-.33.03-.66.05-1.02.07
                             -3.06.34-5.98-1-5.98-2.07
                             v-13a2 2 0 012-2h8
                             a2 2 0 012 2v13" />
                </svg>
                <span>Admin</span>
            </a>

            {{-- Falls Gast: Login-Button --}}
            @guest
                <!-- An der gewünschten Stelle in layout.blade.php -->
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
    {{$slot}}
</div>

</body>
</html>
