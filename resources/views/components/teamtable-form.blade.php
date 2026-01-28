@props(['teams', 'disciplines'])

<div class="w-full mx-auto">
    <form id="score-form" action="{{ route('teamTable.storeOrUpdate') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Auswahl-Sektion --}}
        <div class="bg-gradient-to-br from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-800 px-6 py-3 rounded-xl border-2 border-gray-400 dark:border-gray-600 shadow-lg transition-colors duration-300">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879a3 3 0 014.242 0L16 14M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Disziplin & Team auswählen</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Disziplin --}}
                <div class="group">
                    <label for="discipline_id_select" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Disziplin
                        </span>
                    </label>
                    <div class="relative">
                        <select
                            name="discipline_id"
                            id="discipline_id_select"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-sm hover:border-gray-300 dark:hover:border-gray-500 appearance-none cursor-pointer"
                            required>
                            <option value="" disabled {{ old('discipline_id') ? '' : 'selected' }} class="text-gray-400 dark:text-gray-500">-- Bitte wählen --</option>
                            @foreach($disciplines as $discipline)
                                <option value="{{ $discipline->id }}" {{ old('discipline_id') == $discipline->id ? 'selected' : '' }} class="text-gray-800 dark:text-gray-100">
                                    {{ $discipline->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('discipline_id')
                    <div class="flex items-center gap-2 mt-2 text-red-600 dark:text-red-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                {{-- Team --}}
                <div class="group">
                    <label for="team_id_select" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Team
                        </span>
                    </label>
                    <div class="relative">
                        <select
                            name="team_id"
                            id="team_id_select"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-sm hover:border-gray-300 dark:hover:border-gray-500 appearance-none cursor-pointer"
                            required>
                            <option value="" disabled {{ old('team_id') ? '' : 'selected' }} class="text-gray-400 dark:text-gray-500">-- Bitte wählen --</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }} class="text-gray-800 dark:text-gray-100">
                                    {{ $team->name }} ({{ $team->klasse->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('team_id')
                    <div class="flex items-center gap-2 mt-2 text-red-600 dark:text-red-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Score-Eingabe-Sektion --}}
        <div class="bg-gradient-to-br from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-800 px-6 py-3 rounded-xl border-2 border-gray-400 dark:border-gray-600 shadow-lg transition-colors duration-300">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 rounded-lg">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Scores eingeben</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Score 1 --}}
                <div class="group">
                    <label for="score_1_input" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Score 1
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="score_1"
                            id="score_1_input"
                            step="0.01"
                            placeholder="0.00"
                            value="{{ old('score_1', '') }}"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-sm hover:border-gray-300 dark:hover:border-gray-500"
                        >
                    </div>
                    <div id="loaded_score_1_display" class="mt-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-500 p-3 rounded-r-lg" style="display: none;">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-700 dark:text-blue-300 text-xs">Aktuell gespeichert: </span>
                            <span class="font-semibold text-blue-800 dark:text-blue-200 text-xs"></span>
                        </div>
                    </div>
                    @error('score_1')
                    <div class="flex items-center gap-2 mt-2 text-red-600 dark:text-red-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                {{-- Score 2 --}}
                <div class="group">
                    <label for="score_2_input" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Score 2
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="score_2"
                            id="score_2_input"
                            step="0.01"
                            placeholder="0.00"
                            value="{{ old('score_2', '') }}"
                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 text-sm hover:border-gray-300 dark:hover:border-gray-500"
                        >
                    </div>
                    <div id="loaded_score_2_display" class="mt-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-500 p-3 rounded-r-lg" style="display: none;">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-700 dark:text-blue-300 text-xs">Aktuell gespeichert: </span>
                            <span class="font-semibold text-blue-800 dark:text-blue-200 text-xs"></span>
                        </div>
                    </div>
                    @error('score_2')
                    <div class="flex items-center gap-2 mt-2 text-red-600 dark:text-red-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full group relative flex justify-center items-center gap-2 py-3 px-6 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"
        >
            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            Scores speichern / aktualisieren
            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
        </button>
    </form>
</div>
