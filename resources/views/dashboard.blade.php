<x-layout>
    <x-slot:heading>
        Klassen Dashboard
    </x-slot:heading>

    <div class="py-12 bg-gradient-to-br from-blue-100 to-green-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Klasseninformationen --}}
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-indigo-700 mb-4">Willkommen, {{ $klasse->name ?? 'Unbekannte Klasse' }}!</h3>

                        @if($klasse && $klasse->school)
                            <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                                <p class="text-blue-800">
                                    <span class="font-semibold">Schule:</span> {{ $klasse->school->name }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Disziplin-Bereich --}}
                    @if($discipline)
                        <div class="border-t border-gray-200 pt-8">
                            <h3 class="text-xl font-semibold mb-6 text-green-700">
                                Ihre Disziplin: {{ $discipline->name }}
                            </h3>

                            {{-- Disziplin-Informationen --}}
                            <div class="bg-green-50 border border-green-200 p-4 rounded-lg mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-semibold text-green-700">Bewertung:</span>
                                        <span class="text-green-600">
                                            {{ $discipline->higher_is_better ? 'Höher ist besser' : 'Niedriger ist besser' }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-green-700">Max. Punkte:</span>
                                        <span class="text-green-600">{{ $discipline->score_first }}</span>
                                    </div>

                                    <div class="col-span-2">
                                        <span class="font-semibold text-green-700">Anmerkung</span>
                                        <span class="text-green-600">{{ $discipline->description }}</span>
                                    </div>
                                </div>

                            </div>


                            @if(session('success'))
                                <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-200 shadow-sm" role="alert">
                                    <span class="font-medium">Erfolg!</span> {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error') || $errors->any())
                                <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-200 shadow-sm" role="alert">
                                    <span class="font-medium">Fehler!</span>
                                    @if(session('error'))
                                        {{ session('error') }}
                                    @endif
                                    @if ($errors->any())
                                        Bitte überprüfe die Eingaben:
                                        <ul class="mt-1.5 list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endif

                            {{-- Formular --}}
                            <div class="bg-gray-50 p-6 rounded-lg shadow border border-gray-200">
                                <h4 class="text-lg font-semibold mb-4 text-gray-800">Scores für Teams eintragen</h4>

                                {{-- Korrigierte Form-Action --}}
                                <form method="POST" action="{{ route('teamTable.storeOrUpdate') }}" class="space-y-6">
                                    @csrf

                                    {{-- Disziplin--}}
                                    <input type="hidden" name="discipline_id" value="{{ $discipline->id }}">

                                    {{-- für teacher-score --}}
                                    <select id="discipline_id_select" style="display: none;">
                                        <option value="{{ $discipline->id }}" selected>{{ $discipline->name }}</option>
                                    </select>

                                    {{-- Team Auswahl --}}
                                    <div>
                                        <label for="team_id_select" class="block text-sm font-medium text-gray-700 mb-2">
                                            Team auswählen <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            id="team_id_select"
                                            name="team_id"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        >
                                            <option value="">-- Team wählen --</option>
                                            @foreach($teams as $team)
                                                <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                                    {{ $team->name }} ({{ $team->klasse->name ?? 'Keine Klasse' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Score Eingaben --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="score_1_input" class="block text-sm font-medium text-gray-700 mb-2">
                                                Score 1
                                            </label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                id="score_1_input"
                                                name="score_1"
                                                value="{{ old('score_1') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="z.B. 12.5"
                                            >
                                            {{-- Aktuelle score anzeigen lassen --}}
                                            <div id="loaded_score_1_display" class="mt-1 text-xs text-gray-600" style="display: none;">
                                                Aktuell gespeichert: <span class="font-medium"></span>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="score_2_input" class="block text-sm font-medium text-gray-700 mb-2">
                                                Score 2
                                            </label>
                                            <input
                                                type="number"
                                                step="0.01"
                                                id="score_2_input"
                                                name="score_2"
                                                value="{{ old('score_2') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                                placeholder="z.B. 11.8"
                                            >

                                            <div id="loaded_score_2_display" class="mt-1 text-xs text-gray-600" style="display: none;">
                                                Aktuell gespeichert: <span class="font-medium"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="flex justify-end">
                                        <button
                                            type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200 ease-in-out transform hover:scale-105"
                                        >
                                            Score speichern
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @else
                        {{-- exception wenn meine disziplinen da sind --}}
                        <div class="border-t border-gray-200 pt-8">
                            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg text-center">
                                <div class="text-yellow-600 mb-2">
                                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Keine Disziplin zugeordnet</h3>
                                <p class="text-yellow-700">
                                    Ihrer Klasse wurde noch keine Disziplin zugeordnet.
                                    Bitte wenden Sie sich an einen Administrator.
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript für Score-Loading (nur wenn Disziplin vorhanden) --}}
    @if($discipline)
        <script>
            // Modifizierte Daten nur für eine Disziplin
            window.allScoresData = @json($allScores ?? []);
        </script>
    @endif
</x-layout>
