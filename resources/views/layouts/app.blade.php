<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Darkmode initialisierung - VOR dem Rendering
            function initDarkMode() {
                if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
            }
            initDarkMode();
        </script>
    </head>
    <body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
          data-auth="{{ auth()->check() ? '1' : '0' }}"
          data-roles="{{ auth()->check() ? auth()->user()->getRoleNames()->implode(',') : '' }}">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-800 dark:text-gray-200">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script>
            // Darkmode nach dem Laden erneut prüfen
            document.addEventListener('DOMContentLoaded', function() {
                initDarkMode();
            });

            // Für Livewire-Navigation
            document.addEventListener('livewire:navigated', function() {
                initDarkMode();
            });
        </script>

        <div id="adminBroadcastPopup" class="fixed inset-0 z-[9999] hidden relative" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

                    <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-800">

                        <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>

                        <div class="px-6 pb-8 pt-10 sm:p-8">
                            <div class="flex flex-col items-center">
                                <div class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-blue-50 dark:bg-blue-900/30 sm:mx-0 mb-6">
                                    <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.996.912 2.168 1.92 4.052.26.49.178 1.114-.21 1.488-.31.299-.776.357-1.127.135-.87-.547-1.74-1.257-2.502-2.008L4.69 15.84m5.65 0h.008v.008h-.008v-.008zm-9-3.75h.008v.008h-.008v-.008zm9-3.75h.008v.008h-.008v-.008z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 8.5c1.1 0 2 .9 2 2s-.9 2-2 2M19 7.5c1.8 0 3.5 1.7 3.5 3.5s-1.7 3.5-3.5 3.5" />
                                    </svg>
                                </div>

                                <div class="text-center">
                                    <h3 class="text-2xl font-bold leading-6 text-gray-900 dark:text-white mb-2" id="modal-title">
                                        Wichtige Mitteilung
                                    </h3>
                                    <div class="mt-4">
                                        <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed" data-admin-broadcast-message>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8 border-t border-gray-100 dark:border-gray-800">
                            <button type="button"
                                    data-admin-broadcast-close
                                    disabled
                                    class="inline-flex w-full justify-center rounded-xl bg-gray-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 sm:w-auto dark:bg-blue-600 dark:hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-300 dark:disabled:bg-gray-700 transition-all duration-200">
                                Verstanden <span data-admin-broadcast-timer class="ml-1 opacity-80">(5)</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
