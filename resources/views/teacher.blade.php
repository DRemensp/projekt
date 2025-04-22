{{-- resources/views/teacher.blade.php --}}
<x-layout>
    <x-slot:heading>
        Teacher Dashboard - Score Eingabe
    </x-slot:heading>

    <div class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <h1 class="text-3xl font-bold text-indigo-700 mb-8 text-center border-b pb-4">
                        Scores eintragen / bearbeiten
                    </h1>

                    {{-- Erfolgs-/Fehlermeldungen --}}
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

                    {{-- Das Formular --}}
                        <div class="max-w-2xl mx-auto"> {{-- Maximale Breite für das Formular --}}
                            <x-teamtable-form
                                :disciplines="$disciplines"
                                :teams="$teams"
                            />
                        </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Daten für JavaScript global verfügbar machen --}}
    {{-- WICHTIG: Muss VOR dem Laden von teacher-scores.js im Layout ausgeführt werden --}}
    <script>
        window.allScoresData = @json($allScores);
    </script>

</x-layout>
