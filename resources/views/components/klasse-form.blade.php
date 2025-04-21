{{-- resources/views/components/klasse-form.blade.php --}}
@props(['schools'])

<div> {{-- Kein <vite> Tag hier nötig --}}
    <form action="{{ route('klasses.store') }}" method="POST">
        @csrf

        {{-- School Select --}}
        <div class="mb-4">
            <label for="school_id" class="block text-sm font-medium text-gray-700 mb-1">Zugehörige Schule</label>
            <select
                name="school_id"
                id="school_id"
                class="w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm appearance-none"
                required>
                <option value="" disabled {{ old('school_id') ? '' : 'selected' }}>-- Bitte wählen --</option>
                @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
            @error('school_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Name Input --}}
        <div class="mb-4">
            <label for="klasse_name" class="block text-sm font-medium text-gray-700 mb-1">Name der Klasse</label>
            <input
                type="text"
                name="klasse_name" {{-- Name im Controller muss matchen --}}
                id="klasse_name"
                placeholder="z.B. 10A"
                required
                value="{{ old('klasse_name') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
            @error('klasse_name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
        >
            Klasse erstellen
        </button>
    </form>
</div>
