<div class="max-w-3xl mx-auto my-8">
    <!-- Cookie-Prüfung für Kommentare -->
    <script>
        // Prüfung der Cookie-Einstellungen für Moderation
        function checkModerationCookies() {
            try {
                const cookieString = document.cookie
                    .split('; ')
                    .find(row => row.startsWith('laravel_cookie_consent='));
                if (cookieString) {
                    const cookieValue = cookieString.split('=')[1];
                    const preferences = JSON.parse(decodeURIComponent(cookieValue));
                    // Verbesserte Validierung
                    return preferences && preferences.moderation === true;
                }
                return false; // Keine Cookies = keine Moderation
            } catch (error) {
                console.log('Cookie-Parsing Error:', error);
                return false;
            }
        }

        // Update-Funktion für Kommentar-Anzeige
        function updateCommentDisplay() {
            const moderationAllowed = checkModerationCookies();
            const commentForm = document.getElementById('comment-form-container');
            const blockedMessage = document.getElementById('moderation-blocked-message');

            if (!moderationAllowed) {
                if (commentForm) commentForm.style.display = 'none';
                if (blockedMessage) blockedMessage.style.display = 'block';
            } else {
                if (commentForm) commentForm.style.display = 'block';
                if (blockedMessage) blockedMessage.style.display = 'none';
            }
        }

        // Verbesserte Event-Handler - verhindert Mehrfachinitialisierung
        let isInitialized = false;

        function initializeCommentDisplay() {
            if (isInitialized) return;
            isInitialized = true;

            updateCommentDisplay();

            // Event Listeners
            window.addEventListener('cookiePreferencesUpdated', updateCommentDisplay);
            document.addEventListener('livewire:navigated', updateCommentDisplay);

            // Optimierter MutationObserver nur für spezifische Änderungen
            const observer = new MutationObserver(function(mutations) {
                let shouldUpdate = false;
                mutations.forEach(function(mutation) {
                    if (mutation.target.id === 'comment-form-container' ||
                        mutation.target.id === 'moderation-blocked-message') {
                        shouldUpdate = true;
                    }
                });
                if (shouldUpdate) {
                    updateCommentDisplay();
                }
            });

            const container = document.querySelector('.max-w-3xl');
            if (container) {
                observer.observe(container, { childList: true, subtree: false });
            }
        }

        // DOM laden abwarten
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCommentDisplay);
        } else {
            initializeCommentDisplay();
        }
    </script>

    <!-- Eingabebereich - nur wenn Kommentare aktiviert sind -->
    @if($commentsEnabled)
    <div id="comment-form-container" wire:ignore style="display: none;" class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100 shadow-sm">
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

        @if (session()->has('comment_pending'))
            <div class="mb-4 p-3 bg-yellow-100 border border-yellow-300 text-yellow-700 rounded-lg text-sm">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('comment_pending') }}
                </div>
            </div>
        @endif

        @if (session()->has('comment_blocked'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-lg text-sm">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    {{ session('comment_blocked') }}
                </div>
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
                <span class="text-xs text-gray-500"
                      x-data="{ count: 0 }"
                      x-init="$watch('$wire.message', value => count = value ? value.length : 0)"
                      x-text="count + '/150'">
                </span>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                >
                    <span wire:loading.remove>
                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
    @endif

    <!-- Nachricht wenn Kommentare deaktiviert sind -->
    @if(!$commentsEnabled)
        <div class="mb-8 bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-300 shadow-sm">
            <div class="text-center">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Kommentare deaktiviert</h3>
                <p class="text-gray-600 text-sm">
                    Die Kommentarfunktion wurde vom Administrator vorübergehend deaktiviert.
                </p>
            </div>
        </div>
    @endif

    <!-- Blockierte Nachricht für Moderation -->
    <div id="moderation-blocked-message" wire:ignore.self style="display: none;" class="mb-8 bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-xl border border-orange-200 shadow-sm">
        <div class="text-center">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Cookie-Einstellungen erforderlich</h3>
            <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                Um Kommentare zu schreiben, müssen Sie Moderation-Cookies akzeptieren.
                Diese helfen uns dabei, eine spam- und missbrauchsfreie Umgebung zu schaffen.
            </p>
            <button data-action="show-cookie-settings"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Cookie-Einstellungen öffnen
            </button>
        </div>
    </div>

    <script>
        // Namespace verwenden statt globale Funktion überschreiben
        window.CommentSystem = window.CommentSystem || {};

        window.CommentSystem.showCookieSettings = function() {
            // Cookie-Einstellungen zurücksetzen und Banner wieder anzeigen
            document.cookie = 'laravel_cookie_consent=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
            // Seite neu laden, damit der Banner wieder erscheint
            window.location.reload();
        };

        // Event-Delegation mit verbesserter Fehlerbehandlung
        document.addEventListener('click', function(event) {
            const target = event.target.closest('[data-action="show-cookie-settings"]');
            if (target) {
                event.preventDefault();
                window.CommentSystem.showCookieSettings();
            }
        });
    </script>

    <!-- Kommentar-Anzeige -->
    @if(isset($comments) && $comments->count() > 0)
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2" wire:poll.15s>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z" />
                    </svg>
                    Kommentare ({{ $totalComments }})
                </h3>

                {{-- Moderation-Button nur für Admin und Teacher --}}
                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                        <a href="{{ route('moderation.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200 shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Moderation
                        </a>
                    @endif
                @endauth
            </div>

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
                                        aria-label="Kommentar löschen"
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
                                aria-label="5 weitere Kommentare laden"
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
                                    aria-label="Nur die neuesten 5 Kommentare anzeigen"
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
