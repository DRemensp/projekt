<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>


</head>
<body class="h-full">

<!-- Ab hier dein bisheriger Inhalt -->
<div class="min-h-full">
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <img
                            class="size-8"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                            alt="Your Company"
                        >
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                            <x-nav-link href="/teacher" :active="request()->is('teacher')">Teacher</x-nav-link>
                            <x-nav-link href="/admin" :active="request()->is('admin')">Admin</x-nav-link>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <button
                            type="button"
                            class="relative rounded-full bg-gray-800 p-1 text-gray-400
                                   hover:text-white focus:ring-2 focus:ring-white
                                   focus:ring-offset-2 focus:ring-offset-gray-800
                                   focus:outline-hidden"
                        >
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg
                                class="size-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022
                                       c1.733.64 3.56 1.085 5.455 1.31m5.714 0
                                       a24.255 24.255 0 0 1-5.714 0m5.714 0
                                       a3 3 0 1 1-5.714 0"
                                />
                            </svg>
                        </button>
                        <!-- Profile dropdown -->
                        <div class="ml-4 flex items-center md:ml-6">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center focus:outline-nonepx-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-md"
                            >Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Hauptinhalt -->
    <header class="bg-transparent shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 flex-auto text-center">{{$heading}}</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{$slot}}
        </div>
    </main>
</div>
</body>
</html>
