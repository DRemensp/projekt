{{-- resources/views/components/teamtable-form.blade.php --}}
@props(['teams', 'disciplines'])

{{-- Die Komponente selbst rendert jetzt direkt den Formular-Container --}}
{{-- Leichter Schatten, abgerundete Ecken, Rand --}}
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md border border-gray-200">
    <form id="score-form" action="{{ route('teamTable.storeOrUpdate') }}" method="POST">
        @csrf

        {{-- Abschnitt 1: Auswahl --}}
        <fieldset class="mb-8">
            <legend class="text-xl font-semibold mb-6 text-center text-gray-800 flex items-center justify-center gap-2">
                {{-- Auswahl-Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l2.879-2.879a3 3 0 014.242 0L16 14M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Disziplin & Team auswählen</span>
            </legend>

            {{-- Styling für den Auswahlbereich, ähnlich den Admin-Formular-Boxen --}}
            <div class="space-y-5 bg-gray-50 p-5 rounded-md border border-gray-200 shadow-inner">
                {{-- Disziplin Select --}}
                <div>
                    <label for="discipline_id_select" class="block text-sm font-medium text-gray-700 mb-1">Disziplin</label>
                    <select
                        name="discipline_id"
                        id="discipline_id_select" {{-- ID für JS --}}
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required
                    >
                        <option value="">-- Bitte wählen --</option>
                        @foreach($disciplines as $discipline)
                            <option value="{{ $discipline->id }}" {{ old('discipline_id') == $discipline->id ? 'selected' : '' }}>
                                {{ $discipline->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('discipline_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Team Select --}}
                <div>
                    <label for="team_id_select" class="block text-sm font-medium text-gray-700 mb-1">Team</label>
                    <select
                        name="team_id"
                        id="team_id_select" {{-- ID für JS --}}
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required
                    >
                        <option value="">-- Bitte wählen --</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                {{ $team->name }} ({{ $team->klasse->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('team_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        {{-- Abschnitt 2: Score-Eingabe --}}
        <fieldset>
            <legend class="text-xl font-semibold mb-6 text-center text-gray-800 flex items-center justify-center gap-2">
                {{-- Eingabe-Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Scores eingeben</span>
            </legend>

            <div class="space-y-5">
                {{-- Score 1 Input --}}
                <div>
                    <label for="score_1_input" class="block text-sm font-medium text-gray-700 mb-1">Score 1</label>
                    <input
                        type="number"
                        name="score_1"
                        id="score_1_input" {{-- ID für JS --}}
                        step="0.01"
                        placeholder="0.00"
                        value="{{ old('score_1', '') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                    {{-- Verbesserte Anzeige für geladenen Score --}}
                    <div id="loaded_score_1_display" class="mt-2 bg-blue-50 border-l-4 border-blue-300 p-2 text-xs rounded-md" style="display: none;">
                        <span class="text-blue-700">Aktuell gespeichert: </span>
                        <span class="font-semibold text-blue-800"></span> {{-- Wert wird von JS eingefügt --}}
                    </div>
                    @error('score_1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Score 2 Input --}}
                <div>
                    <label for="score_2_input" class="block text-sm font-medium text-gray-700 mb-1">Score 2</label>
                    <input
                        type="number"
                        name="score_2"
                        id="score_2_input" {{-- ID für JS --}}
                        step="0.01"
                        placeholder="0.00"
                        value="{{ old('score_2', '') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                    {{-- Verbesserte Anzeige für geladenen Score --}}
                    <div id="loaded_score_2_display" class="mt-2 bg-blue-50 border-l-4 border-blue-300 p-2 text-xs rounded-md" style="display: none;">
                        <span class="text-blue-700">Aktuell gespeichert: </span>
                        <span class="font-semibold text-blue-800"></span> {{-- Wert wird von JS eingefügt --}}
                    </div>
                    @error('score_2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        {{-- Submit Button (gestyled wie Admin Buttons) --}}
        <button
            type="submit"
            class="w-full mt-10 flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
        >
            {{-- Speicher-Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
            </svg>
            <span>Scores speichern / aktualisieren</span>
        </button>
    </form>
</div>
