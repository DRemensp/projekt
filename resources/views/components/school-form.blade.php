{{-- resources/views/components/school-form.blade.php --}}
<div>
    {{-- action und method werden vom parent view geerbt oder können hier definiert werden --}}
    <form action="{{ route('schools.store') }}" method="POST">
        @csrf

        {{-- Name Input --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name der Schule</label>
            <input
                type="text"
                name="name"
                id="name" {{-- IDs sollten idealerweise eindeutig sein, evtl. Prefix hinzufügen? Hier ok. --}}
                placeholder="z.B. Musterschule"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required
                value="{{ old('name') }}" {{-- Alten Wert bei Validierungsfehler anzeigen --}}
            >
            @error('name') {{-- Fehleranzeige direkt am Feld --}}
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button
            type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
        >
            Schule erstellen
        </button>
    </form>
</div>
