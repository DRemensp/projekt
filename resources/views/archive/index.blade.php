<x-layout>
    <x-slot:heading>
        📚 Archiv der CampusOlympiade
    </x-slot:heading>

    <div class="bg-gradient-to-br from-purple-100 to-blue-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if($archives->isEmpty())
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📚</div>
                    <h2 class="text-2xl font-semibold text-gray-600 mb-2">Noch keine Archive vorhanden</h2>
                    <p class="text-gray-500">Archive werden vom Administrator erstellt.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($archives as $archive)
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $archive->name }}</h3>
                                    <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ $archive->archived_date->format('d.m.Y') }}
                                    </span>
                                </div>

                                @if($archive->description)
                                    <p class="text-gray-600 mb-4 text-sm">{{ $archive->description }}</p>
                                @endif

                                <div class="grid grid-cols-2 gap-4 mb-4 text-center">
                                    <div class="bg-blue-50 p-3 rounded-lg">
                                        <div class="text-2xl font-bold text-blue-600">{{ $archive->data['total_schools'] ?? 0 }}</div>
                                        <div class="text-xs text-blue-500">Schulen</div>
                                    </div>
                                    <div class="bg-green-50 p-3 rounded-lg">
                                        <div class="text-2xl font-bold text-green-600">{{ $archive->data['total_teams'] ?? 0 }}</div>
                                        <div class="text-xs text-green-500">Teams</div>
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
