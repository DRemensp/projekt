<x-layout>
    <x-slot:heading>
        Klassen Dashboard
    </x-slot:heading>

    <div class="bg-gradient-to-br from-blue-100 to-green-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 md:p-8 text-gray-900">

                {{-- Willkommensnachricht --}}
                <div class="mb-3">
                    <h1 class="text-3xl md:text-4xl font-bold text-indigo-700 text-center ">
                        Willkommen, {{ $klasse->name ?? 'Unbekannte Klasse' }}!
                    </h1>
                </div>

                {{-- Erfolgs-/Fehlermeldungen --}}
                @if(session('success'))
                    <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200 shadow-sm" role="alert">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Erfolg!</span> {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-200 shadow-sm" role="alert">
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
                            <h3 class="text-3xl md:text-3xl font-bold text-green-700 mb-2 flex items-center justify-center gap-3">
                                {{ $discipline->name }}
                            </h3>
                            <div class="bg-gradient-to-r from-green-500 to-blue-500 h-1 w-38 mx-auto rounded-full"></div>
                        </div>

                        {{-- Score Eingabe Formular --}}
                        <div class="bg-gradient-to-br from-gray-50 to-blue-50 p-6 md:p-8 rounded-xl border border-gray-400 shadow-inner">
                            <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Scores für Teams eintragen
                            </h4>

                            <form method="POST" action="{{ route('teamTable.storeOrUpdate') }}" class="space-y-6">
                                @csrf

                                {{-- Hidden Disziplin ID --}}
                                <input type="hidden" name="discipline_id" value="{{ $discipline->id }}">
                                <select id="discipline_id_select" style="display: none;">
                                    <option value="{{ $discipline->id }}" selected>{{ $discipline->name }}</option>
                                </select>

                                {{-- Team Auswahl --}}
                                <div class="group">
                                    <label for="team_id_select" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-green-600">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Team auswählen <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <select
                                            id="team_id_select"
                                            name="team_id"
                                            required
                                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm hover:border-gray-300 appearance-none cursor-pointer"
                                        >
                                            <option value="" disabled {{ old('team_id') ? '' : 'selected' }} class="text-gray-400">-- Team wählen --</option>
                                            @foreach($teams as $team)
                                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }} class="text-gray-800">
                                                    {{ $team->name }} ({{ $team->klasse->name ?? 'Keine Klasse' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Score Eingaben --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="group">
                                        <label for="score_1_input" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-green-600">
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
                                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm hover:border-gray-300"
                                                placeholder="z.B. 12.5"
                                            >
                                        </div>
                                        <div id="loaded_score_1_display" class="mt-2 text-xs text-gray-600" style="display: none;">
                                            Aktuell gespeichert: <span class="font-medium bg-gray-100 px-2 py-1 rounded"></span>
                                        </div>
                                    </div>

                                    <div class="group">
                                        <label for="score_2_input" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-green-600">
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
                                                class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm hover:border-gray-300"
                                                placeholder="z.B. 11.8"
                                            >
                                        </div>
                                        <div id="loaded_score_2_display" class="mt-2 text-xs text-gray-600" style="display: none;">
                                            Aktuell gespeichert: <span class="font-medium bg-gray-100 px-2 py-1 rounded"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="flex justify-center pt-4">
                                    <button
                                        type="submit"
                                        class="group relative flex justify-center items-center gap-2 py-3 px-8 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                                    >
                                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Score speichern
                                        <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Disziplin-Informationen --}}
                        <div class="bg-gradient-to-br from-green-50 to-blue-50 border-2 border-gray-300 p-6 rounded-xl mt-6 shadow-inner">
                            <h5 class="text-lg font-bold text-green-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Disziplin-Informationen
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-green-100">
                                    <span class="font-semibold text-green-700 flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Bewertung:
                                    </span>
                                    <span class="text-green-600 font-medium">
                                        {{ $discipline->higher_is_better ? '📈 Höher ist besser' : '📉 Niedriger ist besser' }}
                                    </span>
                                </div>

                                <div class="bg-white p-4 rounded-lg shadow-sm border border-green-100 md:col-span-2">
                                    <span class="font-semibold text-green-700 flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        Anmerkung:
                                    </span>
                                    <span class="text-green-600">{{ $discipline->description ?? 'Nichts Relevantes, bei Fragen Admin fragen' }}</span>
                                </div>
                            </div>
                        </div>


                @else
                    {{-- Keine Disziplin zugewiesen --}}
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 text-center">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.007-5.824-2.562M15 6.306a7.962 7.962 0 00-6 0m6 0a7.962 7.962 0 105.238 3.237M9 6.306a7.962 7.962 0 00-5.238 3.237"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Keine Disziplin zugewiesen</h3>
                        <p class="text-gray-500">Ihrer Klasse wurde noch keine Disziplin zugewiesen. Bitte wenden Sie sich an einen Administrator.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        window.allScoresData = @json($allScores ?? []);
    </script>
</x-layout>
