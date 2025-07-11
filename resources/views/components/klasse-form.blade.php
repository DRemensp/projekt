@props(['schools'])

<div class="max-w-full">
    <form action="{{ route('klasses.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="group">
            <label for="school_id" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-green-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Zugehörige Schule
                </span>
            </label>
            <div class="relative">
                <select
                    name="school_id"
                    id="school_id"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm hover:border-gray-300 appearance-none cursor-pointer"
                    required>
                    <option value="" disabled {{ old('school_id') ? '' : 'selected' }} class="text-gray-400">-- Bitte wählen --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }} class="text-gray-800">
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('school_id')
            <div class="flex items-center gap-2 mt-2 text-red-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="group">
            <label for="klasse_name" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-green-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Name der Klasse
                </span>
            </label>
            <div class="relative">
                <input
                    type="text"
                    name="klasse_name"
                    id="klasse_name"
                    placeholder="z.B. 10A"
                    required
                    value="{{ old('klasse_name') }}"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm hover:border-gray-300"
                >
            </div>
            @error('klasse_name')
            <div class="flex items-center gap-2 mt-2 text-red-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full group relative flex justify-center items-center gap-2 py-3 px-6 rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-700 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
        >
            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Klasse erstellen
            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
        </button>
    </form>
</div>
