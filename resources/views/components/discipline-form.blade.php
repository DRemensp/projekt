{{-- resources/views/components/discipline-form.blade.php --}}
<div>
    <form
        action="{{ route('disciplines.store') }}"
        method="POST"
        class="max-w-sm bg-white p-6 rounded-lg shadow mb-10"
    >
        @csrf

        <h2 class="font-semibold mb-4">Neue Disziplin anlegen</h2>

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
            <label for="disziplin_name" class="block mb-1 font-medium">Name der Disziplin</label>
            <input
                type="text"
                name="discipline_name"
                id="discipline_name"
                placeholder="z.B. Weitsprung"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
        </div>

        <!-- max_score -->
        <div class="mb-4">
            <label for="max_score" class="block mb-1 font-medium">Maximalpunkte</label>
            <input
                type="number"
                name="max_score"
                id="max_score"
                placeholder="z.B. 100"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
        </div>

        <!-- score_step -->
        <div class="mb-4">
            <label for="score_step" class="block mb-1 font-medium">Punktschrittweite</label>
            <input
                type="number"
                name="score_step"
                id="score_step"
                placeholder="z.B. 5"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            >
        </div>

        <!-- description -->
        <div class="mb-4">
            <label for="description" class="block mb-1 font-medium">Beschreibung (optional)</label>
            <textarea
                name="description"
                id="description"
                placeholder="Kurze Beschreibung"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
            ></textarea>
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg
                   hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500
                   focus:ring-offset-2 focus:outline-none"
        >
            Disziplin erstellen
        </button>
    </form>
</div>
