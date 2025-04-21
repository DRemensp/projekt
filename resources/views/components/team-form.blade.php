{{-- resources/views/components/team-form.blade.php --}}
@props(['klasses'])

<div>
    <form action="{{ route('teams.store') }}" method="POST">
        @csrf

        {{-- Klasse Select --}}
        <div class="mb-4">
            <label for="klasse_id" class="block text-sm font-medium text-gray-700 mb-1">Zugehörige Klasse</label>
            <select
                name="klasse_id"
                id="klasse_id"
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
            <label for="team_name" class="block text-sm font-medium text-gray-700 mb-1">Name des Teams</label>
            <input
                type="text"
                name="team_name" {{-- Name im Controller muss matchen --}}
                id="team_name"
                placeholder="z.B. Red Dragons"
                required
                value="{{ old('team_name') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
            @error('team_name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Members Textarea --}}
        <div class="mb-4">
            <label for="members" class="block text-sm font-medium text-gray-700 mb-1">Team-Mitglieder <span class="text-xs text-gray-500">(eine Person pro Zeile)</span></label>
            <textarea
                name="members"
                id="members"
                rows="4"
                placeholder="Person A&#10;Person B&#10;Person C" {{-- &#10; für Zeilenumbruch im Placeholder --}}
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >{{ old('members') }}</textarea> {{-- Alten Wert bei Validierungsfehler anzeigen --}}
            @error('members')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors"
        >
            Team erstellen
        </button>
    </form>
</div>
