{{-- resources/views/components/klasse-form.blade.php --}}
@props(['schools'])

<div >
    <form
        action="{{ route('klasses.store') }}"
        method="POST"
        class="max-w-sm bg-white p-6 rounded-lg shadow mb-10"

    >
        @csrf

        <h2 class="font-semibold mb-4">Neue Klasse anlegen</h2>

        <!-- school_id -->
        <div class="mb-4">
            <label for="school_id" class="block mb-1 font-medium">School ID</label>
            <select
                type="number"
                name="school_id"
                id="school_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @foreach($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>

        </div>

        <!-- name -->
        <div class="mb-4">
            <label for="klasse_name" class="block mb-1 font-medium">Name der Klasse</label>
            <input
                type="text"
                name="klasse_name"
                id="klasse_name"
                placeholder="z.B. 10A"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg
                   hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500
                   focus:ring-offset-2 focus:outline-none"
        >
            Klasse erstellen
        </button>
    </form>
</div>
