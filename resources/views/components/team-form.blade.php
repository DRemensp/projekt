@props(['klasses'])

<div class="max-w-full">
    <form action="{{ route('teams.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="group">
            <label for="klasse_id" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-purple-600">
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
                    id="klasse_id"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-sm hover:border-gray-300 appearance-none cursor-pointer"
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
            <label for="team_name" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-purple-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Name des Teams
                </span>
            </label>
            <div class="relative">
                <input
                    type="text"
                    name="team_name"
                    id="team_name"
                    placeholder="z.B. Red Dragons"
                    required
                    value="{{ old('team_name') }}"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-sm hover:border-gray-300"
                >
            </div>
            @error('team_name')
            <div class="flex items-center gap-2 mt-2 text-red-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs font-medium">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="group">
            <label for="members" class="block text-sm font-semibold text-gray-800 mb-2 transition-colors group-focus-within:text-purple-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Team-Mitglieder
                    <span class="text-xs text-gray-500 font-normal">(eine Person pro Zeile)</span>
                </span>
            </label>
            <div class="relative">
                <textarea
                    name="members"
                    id="members"
                    rows="4"
                    placeholder="Person A&#10;Person B&#10;Person C"
                    class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-sm hover:border-gray-300 resize-none"
                >{{ old('members') }}</textarea>
                <div class="absolute top-3 right-3">
                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            @error('members')
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
            class="w-full group relative flex justify-center items-center gap-2 py-3 px-6 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
        >
            <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Team erstellen
            <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-200"></div>
        </button>
    </form>
</div>
