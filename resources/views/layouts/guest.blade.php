<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Design --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- ruft schript auf --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Darkmode initialisierung - VOR dem Rendering
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-white dark:bg-gray-900 transition-colors duration-300">

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-100 to-green-100 dark:from-blue-900 dark:to-green-900">
    <div>
        <a href="/" wire:navigate>
            <x-application-logo class="w-20 h-20 fill-current text-indigo-700 dark:text-indigo-400" />
        </a>
    </div>


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg transition-colors duration-300">
        {{ $slot }}
    </div>
</div>
</body>
</html>
