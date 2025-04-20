{{-- resources/views/components/school-form.blade.php --}}
<div>
    <form
        action="{{ route('schools.store') }}"
        method="POST"
        class="max-w-sm bg-white p-6 rounded-lg shadow mb-10"
    >
        @csrf

        <h2 class="font-semibold mb-4">Neue Schule anlegen</h2>

        <div class="mb-4">
            <label for="name" class="block mb-1 font-medium">Name der Schule</label>
            <input
                type="text"
                name="name"
                id="name"
                placeholder="z.B. Musterschule"
                class="w-full rounded-lg border border-gray-300 px-3 py-2
                       focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none"
                required
            >
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg
                   hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500
                   focus:ring-offset-2 focus:outline-none"
        >
            Schule erstellen
        </button>
    </form>
</div>
