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
<body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-white dark:bg-gray-900 transition-colors duration-300"
      data-auth="{{ auth()->check() ? '1' : '0' }}"
      data-roles="{{ auth()->check() ? auth()->user()->getRoleNames()->implode(',') : '' }}">

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

<div id="adminBroadcastPopup" class="fixed bottom-6 right-6 z-50 hidden w-[min(90vw,24rem)]">
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Admin Nachricht</p>
                <p class="mt-1 text-sm text-gray-800 dark:text-gray-100" data-admin-broadcast-message></p>
            </div>
            <button type="button"
                    data-admin-broadcast-close
                    class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm font-semibold disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-150">
                X <span data-admin-broadcast-timer class="text-xs"></span>
            </button>
        </div>
    </div>
</div>
</body>
</html>
