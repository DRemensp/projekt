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

<div id="adminBroadcastPopup" class="fixed inset-0 z-[9999] hidden relative" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-950/80 backdrop-blur transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg ring-1 ring-white/10">

                <div class="px-6 py-8 sm:p-10">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </div>

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-bold leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Neue Ankündigung
                            </h3>
                            <div class="mt-4">
                                <div class="relative rounded-lg bg-gray-50 dark:bg-gray-800/50 p-4 border border-gray-100 dark:border-gray-700">
                                    <p class="text-base text-gray-700 dark:text-gray-300 font-medium leading-relaxed" data-admin-broadcast-message>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-10 border-t border-gray-100 dark:border-gray-800">
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
</body>
</html>
