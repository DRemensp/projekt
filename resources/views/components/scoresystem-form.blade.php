{{-- scoresystem-form.blade.php --}}
<div class="max-w-full">
    <form action="{{ route('scoresystem.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Platz 1-3 Section --}}
        <div class="bg-white p-4 rounded-xl border border-gray-300">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Podiumsplätze
            </h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="group">
                    <label for="first_place" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-yellow-600">
                        <span class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white text-xs font-bold">1</div>
                            1. Platz
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="first_place"
                            id="first_place"
                            placeholder="z.B. 200"
                            required
                            min="0"
                            value="{{ old('first_place') }}"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-200 text-sm hover:border-gray-300"
                        >
                    </div>
                    @error('first_place')
                    <div class="flex items-center gap-2 mt-2 text-red-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="group">
                    <label for="second_place" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-gray-600">
                        <span class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center text-white text-xs font-bold">2</div>
                            2. Platz
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="second_place"
                            id="second_place"
                            placeholder="z.B. 150"
                            required
                            min="0"
                            value="{{ old('second_place') }}"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-all duration-200 text-sm hover:border-gray-300"
                        >
                    </div>
                    @error('second_place')
                    <div class="flex items-center gap-2 mt-2 text-red-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="group">
                    <label for="third_place" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-amber-600">
                        <span class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-amber-500 to-amber-700 rounded-full flex items-center justify-center text-white text-xs font-bold">3</div>
                            3. Platz
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="third_place"
                            id="third_place"
                            placeholder="z.B. 120"
                            required
                            min="0"
                            value="{{ old('third_place') }}"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 text-sm hover:border-gray-300"
                        >
                    </div>
                    @error('third_place')
                    <div class="flex items-center gap-2 mt-2 text-red-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Weitere Plätze Section --}}
        <div class="bg-white p-4 rounded-xl border border-slate-200">
            <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Weitere Plätze
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="group">
                    <label for="max_score" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-blue-600">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Ab 4. Platz Punkte
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="max_score"
                            id="max_score"
                            placeholder="z.B. 100"
                            required
                            min="0"
                            value="{{ old('max_score') }}"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm hover:border-gray-300"
                        >
                    </div>
                    @error('max_score')
                    <div class="flex items-center gap-2 mt-2 text-red-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>

                <div class="group">
                    <label for="score_step" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-blue-600">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                            Punktabzug pro Platz
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="score_step"
                            id="score_step"
                            placeholder="z.B. 10"
                            required
                            min="1"
                            value="{{ old('score_step') }}"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm hover:border-gray-300"
                        >
                    </div>
                    @error('score_step')
                    <div class="flex items-center gap-2 mt-2 text-red-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Bonus Punkte Section --}}
        <div class="bg-white p-4 rounded-xl border border-gray-300">
            <div class="grid grid-cols-1 gap-4">
                <div class="group">
                    <label for="bonus_score" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-green-600">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Bonus Punkte
                        </span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            name="bonus_score"
                            id="bonus_score"
                            placeholder="z.B. 50"
                            required
                            min="0"
                            value="{{ old('bonus_score') }}"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 text-sm hover:border-gray-300"
                        >
                    </div>
                    <p class="mt-2 text-xs text-black flex items-center gap-1">
                        <svg class="w-3 h-3 mr-2 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Zusätzliche Punkte für Einheitliche Outfits
                    </p>
                    @error('bonus_score')
                    <div class="flex items-center gap-2 mt-2 text-red-600">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs font-medium">{{ $message }}</span>
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <button
            type="submit"
            class="w-full group relative flex justify-center items-center gap-2 py-3 px-6 rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-orange-400 to-amber-700 hover:from-orange-500 hover:to-amber-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
        >
            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Scoresystem konfigurieren
            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
        </button>
    </form>
</div>
