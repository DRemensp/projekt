{{-- resources/views/components/discipline-form.blade.php --}}
@props(['klasses'])

<div>
    <form action="{{ route('disciplines.store') }}" method="POST">
        @csrf

        {{-- Klasse Select --}}
        <div class="mb-4">
            <label for="discipline_klasse_id" class="block text-sm font-medium text-gray-700 mb-1">Zugehörige Klasse</label> {{-- ID geändert wegen möglicher Kollision --}}
            <select
                name="klasse_id"
                id="discipline_klasse_id"
                class="w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm appearance-none"
                required>
                <option value="" disabled {{ old('klasse_id') ? '' : 'selected' }}>-- Bitte wählen --</option>
                @foreach($klasses as $klasse)
                    <option value="{{ $klasse->id }}" {{ old('klasse_id') == $klasse->id ? 'selected' : '' }}>
                        {{ $klasse->name }} ({{ $klasse->school->name ?? '?' }})
                    </option>
                @endforeach
            </select>
            @error('klasse_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name Input --}}
        <div class="mb-4">
            <label for="discipline_name" class="block text-sm font-medium text-gray-700 mb-1">Name der Disziplin</label>
            <input
                type="text"
                name="discipline_name" {{-- Name im Controller muss matchen --}}
                id="discipline_name"
                placeholder="z.B. Weitsprung"
                required
                value="{{ old('discipline_name') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
            @error('discipline_name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Grid für Zahlenwerte --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            {{-- max_score --}}
            <div>
                <label for="max_score" class="block text-sm font-medium text-gray-700 mb-1">Maximalpunkte</label>
                <input
                    type="number"
                    name="max_score"
                    id="max_score"
                    placeholder="z.B. 100"
                    required
                    min="0"
                    value="{{ old('max_score') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                @error('max_score') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- score_step --}}
            <div>
                <label for="score_step" class="block text-sm font-medium text-gray-700 mb-1">Punktschrittweite (wie viel weniger bekommt das nächste team)</label>
                <input
                    type="number"
                    name="score_step"
                    id="score_step"
                    placeholder="z.B. 5"
                    required
                    min="1"
                    value="{{ old('score_step') }}" {{-- Default-Wert 5 --}}
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                @error('score_step') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>


        {{-- higher_is_better Select --}}
        <div class="mb-4">
            <label for="higher_is_better" class="block text-sm font-medium text-gray-700 mb-1">Wertung (Ist höher besser?)</label>
            <select
                name="higher_is_better"
                id="higher_is_better"
                class="w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm appearance-none"
                required
            >
                <option value="1" {{ old('higher_is_better', '1') == '1' ? 'selected' : '' }}>Ja (z.B. Weitwurf, Hochsprung)</option>
                <option value="0" {{ old('higher_is_better') == '0' ? 'selected' : '' }}>Nein (z.B. Sprintzeit)</option>
            </select>
            @error('higher_is_better') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Description Textarea --}}
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Beschreibung <span class="text-xs text-gray-500">(optional)</span></label>
            <textarea
                name="description"
                id="description"
                rows="3"
                placeholder="Kurze Beschreibung der Disziplin oder Regeln"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >{{ old('description') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors"
        >
            Disziplin erstellen
        </button>
    </form>
</div>
