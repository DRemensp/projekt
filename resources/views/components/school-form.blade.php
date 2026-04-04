{{-- school-form.blade.php --}}
<div class="w-full mx-auto">
    <form action="{{ route('schools.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="group">
            <label for="name" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2 transition-colors group-focus-within:text-indigo-600 dark:group-focus-within:text-indigo-400">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Name der Schule
                </span>
            </label>
            <div class="relative">
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="z.B. Musterschule"
                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-indigo-500 dark:focus:border-indigo-400 transition-all duration-300 text-sm hover:border-gray-300 dark:hover:border-gray-500 group-focus-within:border-indigo-300 dark:group-focus-within:border-indigo-500"
                    required
                    value="{{ old('name') }}"
                >
            </div>
            @error('name')
            <div class="flex items-center gap-2 mt-2 text-red-600 dark:text-red-400">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full group relative flex justify-center items-center gap-2 py-3 px-6 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"
        >
            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Schule erstellen
            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
        </button>
    </form>
</div>
