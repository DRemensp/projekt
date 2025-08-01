<div wire:poll.15s class="max-w-3xl mx-auto my-8">
    <!-- Eingabebereich -->
    <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            Kommentar schreiben
        </h3>

        @if (session()->has('comment_success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">
                {{ session('comment_success') }}
            </div>
        @endif

        <form wire:submit.prevent="store" class="space-y-4">
            <!-- Name Eingabe -->
            <div>
                <label for="authorName" class="block text-sm font-medium text-gray-700 mb-1">
                    Name (optional)
                </label>
                <input
                    wire:model.defer="authorName"
                    type="text"
                    id="authorName"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    placeholder="Dein Name (wird öffentlich angezeigt)"
                    maxlength="50"
                >
                @error('authorName')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nachricht Eingabe -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                    Nachricht <span class="text-red-500">*</span>
                </label>
                <input
                    wire:model.defer="message"
                    type="text"
                    id="message"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    placeholder="Schreibe einen Kommentar... (max 150 Zeichen)"
                    required
                    maxlength="150"
                    x-data="{
                        handleKeydown(event) {
                            if (event.key === 'Enter') {
                                event.preventDefault();
                                $wire.store();
                            }
                        }
                    }"
                    @keydown="handleKeydown($event)"
                >
                @error('message')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <span class="text-xs text-gray-500" x-data x-text="$wire.message ? $wire.message.length + '/150' : '0/150'" x-on:input.window="$el.textContent = $wire.message ? $wire.message.length + '/150' : '0/150'"></span>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                >
                    <span wire:loading.remove>
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2"/>
                        </svg>
                    </span>
                    <span wire:loading>
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove>Senden</span>
                    <span wire:loading>Sende...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Kommentare Anzeige -->
    @if(isset($comments) && $comments->count() > 0)
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z" />
                </svg>
                Kommentare ({{ $totalComments }})
            </h3>

            <div class="space-y-3">
                @foreach($comments as $comment)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2 flex-grow">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ strtoupper(substr($comment->author_name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">
                                        {{ $comment->author_name ?? 'Anonym' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $comment->created_at->format('d.m.Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Lösch-Button nur für Admin und Teacher --}}
                            @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                                    <button
                                        wire:click="destroy({{ $comment->id }})"
                                        wire:confirm="Kommentar von {{ $comment->author_name ?? 'Anonym' }} wirklich löschen?"
                                        class="ml-2 text-red-500 hover:text-red-700 transition-colors duration-150 p-1 rounded hover:bg-red-100 flex-shrink-0"
                                        title="Kommentar löschen"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            @endauth
                        </div>
                        <p class="text-gray-700 break-words leading-relaxed">{{ $comment->message }}</p>
                    </div>
                @endforeach

                <!-- Pagination Controls -->
                @if($hasMoreComments || $commentsToShow > 5)
                    <div class="text-center py-4 space-y-3">
                        @if($hasMoreComments)
                            <button
                                wire:click="loadMore"
                                class="inline-flex items-center gap-2 px-6 py-2 text-blue-600 hover:text-blue-700 font-medium text-sm bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50"
                            >
                                <span wire:loading.remove wire:target="loadMore">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="loadMore">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                                <span wire:loading.remove wire:target="loadMore">
                                    5 weitere laden ({{ $totalComments - $commentsToShow }} verbleibend)
                                </span>
                                <span wire:loading wire:target="loadMore">
                                    Lade...
                                </span>
                            </button>
                        @endif

                        @if($commentsToShow > 5)
                            <div>
                                <button
                                    wire:click="showLess"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-700 font-medium text-sm bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                    </svg>
                                    Nur die neuesten 5 anzeigen
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-gray-600 font-medium">Noch keine Kommentare vorhanden</p>
            <p class="text-gray-500 text-sm">Sei der Erste, der einen Kommentar schreibt!</p>
        </div>
    @endif
</div>
