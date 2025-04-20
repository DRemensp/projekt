{{-- resources/views/components/team-form.blade.php --}}
@props(['klasses'])

<div>
    <form
        action="{{ route('teams.store') }}"
        method="POST"
        class="max-w-sm bg-white p-6 rounded-lg shadow mb-10"
    >
        @csrf

        <h2 class="font-semibold mb-4">Neues Team anlegen</h2>

        <!-- klasse_id -->
        <div class="mb-4">
            <label for="klasse_id" class="block mb-1 font-medium">Klasse ID</label>
            <select
                type="number"
                name="klasse_id"
                id="klasse_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
                @foreach($klasses as $klasse)
                    <option value="{{ $klasse->id }}">{{ $klasse->name }}</option>
                @endforeach
            </select>

        </div>

        <!-- name -->
        <div class="mb-4">
            <label for="team_name" class="block mb-1 font-medium">Name des Teams</label>
            <input
                type="text"
                name="team_name"
                id="team_name"
                placeholder="z.B. Red Dragons"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
        </div>

        <!-- members -->
        <div class="mb-4">
            <label for="members" class="block mb-1 font-medium">Team-Mitglieder (eine Person pro Zeile)</label>
            <textarea
                name="members"
                id="members"
                rows="3"
                placeholder="Person A
Person B"
                class="w-full rounded-lg border border-gray-300 px-3 py-2"
            ></textarea>
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg
                   hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500
                   focus:ring-offset-2 focus:outline-none"
        >
            Team erstellen
        </button>
    </form>
</div>
