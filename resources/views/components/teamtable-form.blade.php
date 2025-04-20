{{-- resources/views/components/teamtable-form.blade.php --}}
@props(['teams', 'disciplines'])

<div>
    {{-- Ausgabe von Validierungsfehlern --}}
    @if ($errors->any())
        <div class="text-red-600 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teamTable.storeOrUpdate') }}" method="POST" class="max-w-sm bg-white p-6 rounded-lg shadow mb-10">
        @csrf
        <h2 class="font-semibold mb-4">Team/Disziplin verknüpfen</h2>

        <!-- Auswahl für Disziplin -->
        <div class="mb-4">
            <label for="discipline_id" class="block mb-1 font-medium">Disziplin</label>
            <select
                name="discipline_id"
                id="discipline_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                   focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                required
            >
                <option disabled selected>Bitte wählen</option>
                @foreach($disciplines as $discipline)
                    <option value="{{ $discipline->id }}">{{ $discipline->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Auswahl für Team -->
        <div class="mb-4">
            <label for="team_id" class="block mb-1 font-medium">Team</label>
            <select
                name="team_id"
                id="team_id"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                   focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                required
            >
                <option disabled selected>Bitte wählen</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- score_1 -->
        <div class="mb-4">
            <label for="score_1" class="block mb-1 font-medium">Score 1</label>
            <input
                type="number"
                name="score_1"
                id="score_1"
                step="0.01"
                placeholder="z.B. 10,5"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                   focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
        </div>

        <!-- score_2 -->
        <div class="mb-4">
            <label for="score_2" class="block mb-1 font-medium">Score 2</label>
            <input
                type="number"
                name="score_2"
                id="score_2"
                step="0.01"
                placeholder="z.B. 8"
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
            Speichern
        </button>
    </form>
</div>
