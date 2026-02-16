<x-layout>
    <x-slot:heading>
        Klassen Dashboard
    </x-slot:heading>

    <div class="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen transition-colors duration-300 dark:bg-none">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 transition-colors duration-300">

                {{-- Willkommensnachricht --}}
                <div class="mb-3">
                    <h1 class="display-font text-3xl md:text-4xl font-bold text-indigo-700 dark:text-indigo-300 text-center transition-colors duration-300">
                        Willkommen, {{ $klasse->name ?? 'Unbekannte Klasse' }}!
                    </h1>
                </div>

                {{-- Erfolgs-/Fehlermeldungen --}}
                @if(session('success'))
                    <div class="mb-6 p-4 text-sm text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-700 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300" role="alert">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Erfolg!</span> {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div class="mb-6 p-4 text-sm text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-700 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300" role="alert">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Fehler!</span>
                        </div>
                        @if(session('error'))
                            {{ session('error') }}
                        @endif
                        @if ($errors->any())
                            <div class="mt-2">
                                Bitte überprüfe die Eingaben:
                                <ul class="mt-1.5 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Disziplin-Bereich --}}
                @if($discipline)

                        {{-- Disziplin Header --}}
                        <div class="mb-6 text-center">
                            <h3 class="display-font text-3xl md:text-3xl font-bold text-green-700 dark:text-green-300 mb-2 flex items-center justify-center gap-3 transition-colors duration-300">
                                {{ $discipline->name }}
                            </h3>
                            <div class="bg-gradient-to-r from-green-500 to-blue-500 dark:from-green-600 dark:to-blue-600 h-1 w-38 mx-auto rounded-full transition-colors duration-300"></div>
                        </div>

                        {{-- Score Eingabe Formular --}}
                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 night-panel dark:from-gray-800 dark:to-gray-700 p-6 md:p-8 rounded-xl border border-gray-400 dark:border-gray-600 shadow-inner dark:shadow-gray-900/50 transition-colors duration-300">
                            <h4 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center gap-2 transition-colors duration-300">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Scores für Teams eintragen
                            </h4>

                            <div class="mb-6">
                                <div class="flex flex-wrap items-center gap-3">
                                    <button
                                        id="open-qr-camera-modal"
                                        type="button"
                                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:from-blue-700 hover:to-indigo-700"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.55-2.28A1 1 0 0121 8.62v6.76a1 1 0 01-1.45.9L15 14M4 6h8a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                                        </svg>
                                        QR-Scanner starten
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('teamTable.storeOrUpdate') }}" class="space-y-6">
                                @csrf

                                {{-- Hidden Disziplin ID --}}
                                <input type="hidden" name="discipline_id" value="{{ $discipline->id }}">
                                <select id="discipline_id_select" style="display: none;">
                                    <option value="{{ $discipline->id }}" selected>{{ $discipline->name }}</option>
                                </select>

                                {{-- Team Auswahl --}}
                                <div class="group">
                                    <label for="team_id_select" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors duration-300 group-focus-within:text-green-600 dark:group-focus-within:text-green-400">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Team auswählen <span class="text-red-500 dark:text-red-400">*</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <select
                                            id="team_id_select"
                                            name="team_id"
                                            required
                                            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm dark:shadow-gray-900/50 focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400 transition-all duration-200 text-sm text-gray-800 dark:text-gray-200 hover:border-gray-300 dark:hover:border-gray-500 appearance-none cursor-pointer"
                                        >
                                            <option value="" disabled {{ old('team_id') || $scanTeamId ? '' : 'selected' }} class="text-gray-400 dark:text-gray-500">-- Team wählen --</option>
                                            @foreach($teams as $team)
                                                <option value="{{ $team->id }}" {{ (string) old('team_id', (string) ($scanTeamId ?? '')) === (string) $team->id ? 'selected' : '' }} class="text-gray-800 dark:text-gray-200">
                                                    {{ $team->name }} ({{ $team->klasse->name ?? 'Keine Klasse' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Score Eingaben --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group">
                                        <label for="score_1_input" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors duration-300 group-focus-within:text-green-600 dark:group-focus-within:text-green-400">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                                </svg>
                                                Score 1
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input
                                                type="number"
                                                step="0.01"
                                                id="score_1_input"
                                                name="score_1"
                                                value="{{ old('score_1') }}"
                                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm dark:shadow-gray-900/50 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400 transition-all duration-200 text-sm text-gray-800 dark:text-gray-200 hover:border-gray-300 dark:hover:border-gray-500"
                                                placeholder="z.B. 12.5"
                                            >
                                        </div>
                                        <div id="loaded_score_1_display" class="mt-2 text-xs text-gray-600 dark:text-gray-400 transition-colors duration-300" style="display: none;">
                                            Aktuell gespeichert: <span class="font-medium bg-gray-100 night-card dark:bg-gray-700 px-2 py-1 rounded transition-colors duration-300"></span>
                                        </div>
                                    </div>

                                    <div class="group">
                                        <label for="score_2_input" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors duration-300 group-focus-within:text-green-600 dark:group-focus-within:text-green-400">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                                </svg>
                                                Score 2
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input
                                                type="number"
                                                step="0.01"
                                                id="score_2_input"
                                                name="score_2"
                                                value="{{ old('score_2') }}"
                                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm dark:shadow-gray-900/50 placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400 transition-all duration-200 text-sm text-gray-800 dark:text-gray-200 hover:border-gray-300 dark:hover:border-gray-500"
                                                placeholder="z.B. 11.8"
                                            >
                                        </div>
                                        <div id="loaded_score_2_display" class="mt-2 text-xs text-gray-600 dark:text-gray-400 transition-colors duration-300" style="display: none;">
                                            Aktuell gespeichert: <span class="font-medium bg-gray-100 night-card dark:bg-gray-700 px-2 py-1 rounded transition-colors duration-300"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="flex justify-center pt-4">
                                    <button
                                        type="submit"
                                        class="group relative flex justify-center items-center gap-2 py-3 px-8 border border-transparent rounded-xl shadow-lg dark:shadow-gray-900/50 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 dark:from-green-700 dark:to-blue-700 dark:hover:from-green-800 dark:hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:ring-offset-gray-800 focus:ring-green-500 dark:focus:ring-green-400 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                                    >
                                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Score speichern
                                        <div class="absolute inset-0 rounded-xl bg-white dark:bg-gray-800 opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div id="qr-score-modal" class="fixed inset-0 z-[100] hidden bg-black/60 p-4">
                            <div class="mx-auto mt-16 w-full max-w-lg rounded-2xl border border-gray-200 bg-white p-6 shadow-2xl dark:border-gray-700 dark:bg-gray-800">
                                <div class="mb-5 flex items-center justify-between">
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100">Team per QR bewerten</h5>
                                    <button id="close-qr-score-modal" type="button" class="rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-gray-100">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('teamTable.storeOrUpdate') }}" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="discipline_id" value="{{ $discipline->id }}">

                                    <div>
                                        <label for="qr_team_id_select" class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-200">Team</label>
                                        <select
                                            id="qr_team_id_select"
                                            name="team_id"
                                            required
                                            class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 shadow-sm transition-all duration-200 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-green-400 dark:focus:ring-green-400"
                                        >
                                            <option value="" disabled {{ old('team_id') || $scanTeamId ? '' : 'selected' }}>-- Team wählen --</option>
                                            @foreach($teams as $team)
                                                <option value="{{ $team->id }}" {{ (string) old('team_id', (string) ($scanTeamId ?? '')) === (string) $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }} ({{ $team->klasse->name ?? 'Keine Klasse' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label for="qr_score_1_input" class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-200">Score 1</label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                id="qr_score_1_input"
                                                name="score_1"
                                                value="{{ old('score_1') }}"
                                                class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 shadow-sm transition-all duration-200 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-green-400 dark:focus:ring-green-400"
                                                placeholder="z.B. 12.5"
                                            >
                                        </div>
                                        <div>
                                            <label for="qr_score_2_input" class="mb-2 block text-sm font-semibold text-gray-800 dark:text-gray-200">Score 2</label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                id="qr_score_2_input"
                                                name="score_2"
                                                value="{{ old('score_2') }}"
                                                class="w-full rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm text-gray-800 shadow-sm transition-all duration-200 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:focus:border-green-400 dark:focus:ring-green-400"
                                                placeholder="z.B. 11.8"
                                            >
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-end gap-3 pt-2">
                                        <button id="cancel-qr-score-modal" type="button" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Abbrechen</button>
                                        <button type="submit" class="rounded-xl bg-gradient-to-r from-green-600 to-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-md hover:from-green-700 hover:to-blue-700">Score speichern</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div id="qr-camera-modal" class="fixed inset-0 z-[110] hidden bg-black/70 p-4">
                            <div class="mx-auto mt-12 w-full max-w-xl rounded-2xl border border-gray-200 bg-white p-6 shadow-2xl dark:border-gray-700 dark:bg-gray-800">
                                <div class="mb-4 flex items-center justify-between">
                                    <h5 class="text-lg font-bold text-gray-900 dark:text-gray-100">QR-Scanner</h5>
                                    <button id="close-qr-camera-modal" type="button" class="rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-gray-100">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">Halte den Team-QR-Code in die Kamera. Das Team wird automatisch ausgewählt.</p>
                                <div id="qr-reader" class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700"></div>
                                <p id="qr-scan-status" class="mt-3 text-sm text-gray-600 dark:text-gray-300"></p>
                            </div>
                        </div>

                        {{-- Disziplin-Informationen --}}
                        <div class="bg-gradient-to-br from-green-50 to-blue-50 night-panel dark:from-gray-800 dark:to-gray-700 border-2 border-gray-300 dark:border-gray-600 p-6 rounded-xl mt-6 shadow-inner dark:shadow-gray-900/50 transition-colors duration-300">
                            <h5 class="text-lg font-bold text-green-700 dark:text-green-400 mb-4 flex items-center gap-2 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Disziplin-Informationen
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="bg-white night-card dark:bg-gray-700 p-4 rounded-lg shadow-sm dark:shadow-gray-900/50 border border-green-100 dark:border-green-800 transition-colors duration-300">
                                    <span class="font-semibold text-green-700 dark:text-green-400 flex items-center gap-2 mb-1 transition-colors duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Bewertung:
                                    </span>
                                    <span class="text-green-600 dark:text-green-400 font-medium transition-colors duration-300">
                                        {{ $discipline->higher_is_better ? '📈 Höher ist besser' : '📉 Niedriger ist besser' }}
                                    </span>
                                </div>

                                <div class="bg-white night-card dark:bg-gray-700 p-4 rounded-lg shadow-sm dark:shadow-gray-900/50 border border-green-100 dark:border-green-800 md:col-span-2 transition-colors duration-300">
                                    <span class="font-semibold text-green-700 dark:text-green-400 flex items-center gap-2 mb-1 transition-colors duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        Anmerkung:
                                    </span>
                                    <span class="text-green-600 dark:text-green-400 transition-colors duration-300">{{ $discipline->description ?? 'Keine Eintragung, bei Fragen bitte Admin aufsuchen' }}</span>
                                </div>
                            </div>
                        </div>


                @else
                    {{-- Keine Disziplin zugewiesen --}}
                    <div class="bg-white night-panel dark:bg-gray-800 rounded-xl shadow-lg dark:shadow-gray-900/50 border border-gray-200 dark:border-gray-600 p-8 text-center transition-colors duration-300">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.007-5.824-2.562M15 6.306a7.962 7.962 0 00-6 0m6 0a7.962 7.962 0 105.238 3.237M9 6.306a7.962 7.962 0 00-5.238 3.237"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-2 transition-colors duration-300">Keine Disziplin zugewiesen</h3>
                        <p class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Ihrer Klasse wurde noch keine Disziplin zugewiesen. Bitte wenden Sie sich an einen Administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        window.allScoresData = @json($allScores ?? []);
        window.qrScoreInitialTeamId = @json($scanTeamId ?? null);
        window.qrScoreAutoOpen = @json($openScoreModal ?? false);

        (function () {
            const modal = document.getElementById('qr-score-modal');
            const closeButton = document.getElementById('close-qr-score-modal');
            const cancelButton = document.getElementById('cancel-qr-score-modal');
            const cameraModal = document.getElementById('qr-camera-modal');
            const openCameraButton = document.getElementById('open-qr-camera-modal');
            const closeCameraButton = document.getElementById('close-qr-camera-modal');
            const qrScanStatus = document.getElementById('qr-scan-status');
            const qrTeamSelect = document.getElementById('qr_team_id_select');
            const qrScore1Input = document.getElementById('qr_score_1_input');
            const qrScore2Input = document.getElementById('qr_score_2_input');
            const disciplineSelect = document.getElementById('discipline_id_select');

            if (!modal || !qrTeamSelect || !qrScore1Input || !qrScore2Input || !disciplineSelect) {
                return;
            }

            const openModal = () => modal.classList.remove('hidden');
            const closeModal = () => modal.classList.add('hidden');
            const openCameraModal = () => cameraModal?.classList.remove('hidden');
            const closeCameraModal = () => cameraModal?.classList.add('hidden');

            let cameraScanner = null;
            let isCameraRunning = false;

            const syncScoresFromDatabase = () => {
                const disciplineId = disciplineSelect.value;
                const teamId = qrTeamSelect.value;

                if (!disciplineId || !teamId) {
                    qrScore1Input.value = '';
                    qrScore2Input.value = '';
                    return;
                }

                const key = `${disciplineId}_${teamId}`;
                const currentScores = window.allScoresData?.[key] ?? null;
                qrScore1Input.value = currentScores?.score_1 ?? '';
                qrScore2Input.value = currentScores?.score_2 ?? '';
            };

            const validTeamIds = new Set(Array.from(qrTeamSelect.options).map((option) => String(option.value)));

            const extractTeamIdFromScan = (rawText) => {
                const text = String(rawText || '').trim();
                if (!text) return null;

                try {
                    const parsedUrl = new URL(text, window.location.origin);
                    const teamFromQuery = parsedUrl.searchParams.get('scan_team');
                    if (teamFromQuery && validTeamIds.has(String(teamFromQuery))) {
                        return String(teamFromQuery);
                    }
                } catch (_) {
                }

                if (validTeamIds.has(text)) {
                    return text;
                }

                const match = text.match(/scan_team=(\d+)/i) || text.match(/team[:=](\d+)/i) || text.match(/(\d+)/);
                if (match && validTeamIds.has(String(match[1]))) {
                    return String(match[1]);
                }

                return null;
            };

            const stopCameraScanner = async () => {
                if (cameraScanner && isCameraRunning) {
                    await cameraScanner.stop();
                    await cameraScanner.clear();
                }
                cameraScanner = null;
                isCameraRunning = false;
            };

            const startCameraScanner = async () => {
                if (!window.Html5Qrcode) {
                    if (qrScanStatus) qrScanStatus.textContent = 'Scanner-Bibliothek nicht geladen.';
                    return;
                }

                if (qrScanStatus) qrScanStatus.textContent = 'Kamera wird gestartet...';

                try {
                    cameraScanner = new window.Html5Qrcode('qr-reader');
                    await cameraScanner.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 240, height: 240 } },
                        async (decodedText) => {
                            const foundTeamId = extractTeamIdFromScan(decodedText);
                            if (!foundTeamId) {
                                if (qrScanStatus) qrScanStatus.textContent = 'QR erkannt, aber keine gültige Team-ID gefunden.';
                                return;
                            }

                            qrTeamSelect.value = foundTeamId;
                            syncScoresFromDatabase();
                            if (qrScanStatus) qrScanStatus.textContent = `Team ${foundTeamId} erkannt.`;
                            await stopCameraScanner();
                            closeCameraModal();
                            openModal();
                        },
                        () => {}
                    );

                    isCameraRunning = true;
                    if (qrScanStatus) qrScanStatus.textContent = 'Scanner aktiv.';
                } catch (error) {
                    if (qrScanStatus) qrScanStatus.textContent = 'Kamera konnte nicht gestartet werden. Bitte Zugriff erlauben.';
                }
            };

            if (openCameraButton) {
                openCameraButton.addEventListener('click', async () => {
                    openCameraModal();
                    await startCameraScanner();
                });
            }

            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }
            if (cancelButton) {
                cancelButton.addEventListener('click', closeModal);
            }
            if (closeCameraButton) {
                closeCameraButton.addEventListener('click', async () => {
                    await stopCameraScanner();
                    closeCameraModal();
                });
            }

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
            if (cameraModal) {
                cameraModal.addEventListener('click', async (event) => {
                    if (event.target === cameraModal) {
                        await stopCameraScanner();
                        closeCameraModal();
                    }
                });
            }

            qrTeamSelect.addEventListener('change', syncScoresFromDatabase);

            const initialTeamId = window.qrScoreInitialTeamId;
            if (initialTeamId) {
                qrTeamSelect.value = String(initialTeamId);
                syncScoresFromDatabase();
            }

            if (window.qrScoreAutoOpen && initialTeamId) {
                openModal();
            }

            window.addEventListener('beforeunload', () => {
                stopCameraScanner().catch(() => {});
            });
        })();
    </script>
</x-layout>
