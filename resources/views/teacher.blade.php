<x-layout>
    <x-slot:heading>
        Teacher Dashboard - Score Eingabe
    </x-slot:heading>

    <div class="bg-gradient-to-br from-blue-100 to-green-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900 dark:text-gray-100 transition-colors duration-300">

                    <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-400 text-center border-b border-gray-300 dark:border-gray-600 transition-colors duration-300">
                        Wertungs Editor
                    </h1>


                    @if(session('success'))
                        <div class="mb-6 p-4 text-sm text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded-lg border border-green-200 dark:border-green-700 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300" role="alert">
                            <span class="font-medium">Erfolg</span> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error') || $errors->any())
                        <div class="mb-6 p-4 text-sm text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-900/30 rounded-lg border border-red-200 dark:border-red-700 shadow-sm dark:shadow-gray-900/50 transition-colors duration-300" role="alert">
                            <span class="font-medium">Fehler</span>
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

                    <!-- Formular ist in components gespeichert ^^ -->
                        <div class="max-w-2xl mx-auto"> {{-- Maximale Breite für das Formular --}}
                            <x-teamtable-form
                                :disciplines="$disciplines"
                                :teams="$teams"
                            />
                        </div>

                </div>

        </div>
    </div>


    <script>
        window.allScoresData = @json($allScores);
    </script>

</x-layout>
