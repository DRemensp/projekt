@props(['klasses'])

<div class="max-w-full">
    <form action="{{ route('disciplines.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="group">
            <label for="discipline_klasse_id" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-orange-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Zugehörige Klasse
                </span>
            </label>
            <div class="relative">
                <select
                    name="klasse_id"
                    id="discipline_klasse_id"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm hover:border-gray-300 appearance-none cursor-pointer"
                    required>
                    <option value="" disabled {{ old('klasse_id') ? '' : 'selected' }} class="text-gray-400">-- Bitte wählen --</option>
                    @foreach($klasses as $klasse)
                        <option value="{{ $klasse->id }}" {{ old('klasse_id') == $klasse->id ? 'selected' : '' }} class="text-gray-800">
                            {{ $klasse->name }} ({{ $klasse->school->name ?? '?' }})
                        </option>
                    @endforeach
                </select>
            </div>
            @error('klasse_id')
            <div class="flex items-center gap-2 mt-2 text-red-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="group">
            <label for="discipline_name" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-orange-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    Name der Disziplin
                </span>
            </label>
            <div class="relative">
                <input
                    type="text"
                    name="discipline_name"
                    id="discipline_name"
                    placeholder="z.B. Weitsprung"
                    required
                    value="{{ old('discipline_name') }}"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm hover:border-gray-300"
                >
            </div>
            @error('discipline_name')
            <div class="flex items-center gap-2 mt-2 text-red-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="group">
            <label for="higher_is_better" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-orange-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Wertung (Ist höher besser?)
                </span>
            </label>
            <div class="relative">
                <select
                    name="higher_is_better"
                    id="higher_is_better"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm hover:border-gray-300 appearance-none cursor-pointer"
                    required
                >
                    <option value="1" {{ old('higher_is_better', '1') == '1' ? 'selected' : '' }} class="text-gray-800">Ja (z.B. Weitwurf, Hochsprung)</option>
                    <option value="0" {{ old('higher_is_better') == '0' ? 'selected' : '' }} class="text-gray-800">Nein (z.B. Sprintzeit)</option>
                </select>
            </div>
            @error('higher_is_better')
            <div class="flex items-center gap-2 mt-2 text-red-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="group">
            <label for="description" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-orange-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Beschreibung
                    <span class="text-xs text-gray-500 font-normal">(optional)</span>
                </span>
            </label>
            <div class="relative">
                <textarea
                    name="description"
                    id="description"
                    rows="3"
                    placeholder="Kurze Beschreibung der Disziplin oder Regeln"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-sm hover:border-gray-300 resize-none"
                >{{ old('description') }}</textarea>
                <div class="absolute top-3 right-3">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
            @error('description')
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
            class="w-full group relative flex justify-center items-center gap-2 py-3 px-6 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
        >
            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Disziplin erstellen
            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
        </button>
    </form>
</div>
