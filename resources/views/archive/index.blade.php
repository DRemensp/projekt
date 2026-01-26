<x-layout>
    <x-slot:heading>
        📚 Archiv der CampusOlympiade
    </x-slot:heading>

    <div class="bg-gradient-to-br from-purple-100 to-blue-100 dark:from-gray-800 dark:to-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if($archives->isEmpty())
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📚</div>
                    <h2 class="text-2xl font-semibold text-gray-600 dark:text-gray-300 mb-2 transition-colors duration-300">Noch keine Archive vorhanden</h2>
                    <p class="text-gray-500 dark:text-gray-400 transition-colors duration-300">Archive werden vom Administrator erstellt.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($archives as $archive)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 transition-colors duration-300">{{ $archive->name }}</h3>
                                    <span class="bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 text-xs font-medium px-2.5 py-0.5 rounded-full transition-colors duration-300">
                                        {{ $archive->archived_date->format('d.m.Y') }}
                                    </span>
                                </div>

                                @if($archive->description)
                                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm transition-colors duration-300">{{ $archive->description }}</p>
                                @endif

                                <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                                    <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg transition-colors duration-300">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $archive->data['total_schools'] ?? 0 }}</div>
                                        <div class="text-xs text-blue-500 dark:text-blue-400">Schulen</div>
                                    </div>
                                    <div class="bg-green-50 dark:bg-green-900/30 p-3 rounded-lg transition-colors duration-300">
                                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $archive->data['total_teams'] ?? 0 }}</div>
                                        <div class="text-xs text-green-500 dark:text-green-400">Teams</div>
                                    </div>
                                </div>

                                <a href="{{ route('archive.show', $archive) }}"
                                   class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-2 px-4 rounded-lg hover:from-purple-600 hover:to-blue-600 transition-colors duration-200 text-center block font-medium">
                                    🔍 Archiv ansehen
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layout>
