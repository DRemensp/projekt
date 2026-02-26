{{-- WICHTIG: Das Root-Element muss für Livewire sauber bleiben --}}
<div class="max-w-3xl mx-auto my-8">

    {{-- Wrapper für Alpine Logik - trennt Livewire Root von Alpine Scope --}}
    <div x-data="{
            moderationAllowed: (function() {
                try {
                    const cookieString = document.cookie.split('; ').find(row => row.startsWith('{{ config('cookie-consent.cookie_name') }}='));
                    if (cookieString) {
                        const preferences = JSON.parse(decodeURIComponent(cookieString.split('=')[1]));
                        return (preferences && preferences.moderation === true);
                    }
                } catch (e) {}
                return false;
            })(),
            showFirstUseNotice: false,
            hasNoticeAckCookie() {
                return document.cookie.split('; ').some(row => row.startsWith('comment_notice_ack=1'));
            },
            hideFirstUseNotice() {
                this.showFirstUseNotice = false;
                try {
                    localStorage.setItem('comments_first_use_notice_seen', '1');
                } catch (e) {}
                const expires = new Date();
                expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
                const secureFlag = window.location.protocol === 'https:' ? '; Secure' : '';
                document.cookie = `comment_notice_ack=1; expires=${expires.toUTCString()}; path=/; SameSite=Lax${secureFlag}`;
            },
            init() {
                try {
                    const seenInLocalStorage = localStorage.getItem('comments_first_use_notice_seen') === '1';
                    const seenInCookie = this.hasNoticeAckCookie();
                    this.showFirstUseNotice = !(seenInLocalStorage && seenInCookie);
                } catch (e) {
                    this.showFirstUseNotice = !this.hasNoticeAckCookie();
                }
                window.addEventListener('cookiePreferencesUpdated', () => {
                    try {
                        const c = document.cookie.split('; ').find(r => r.startsWith('{{ config('cookie-consent.cookie_name') }}='));
                        if (c) {
                            const p = JSON.parse(decodeURIComponent(c.split('=')[1]));
                            this.moderationAllowed = (p && p.moderation === true);
                        } else {
                            this.moderationAllowed = false;
                        }
                    } catch(e) { this.moderationAllowed = false; }
                });
            }
         }"
    >

        {{-- 1. EINGABEBEREICH --}}
        @if($commentsEnabled)
            {{-- Formular Container --}}
            <div x-show="moderationAllowed" style="display: none;" class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 p-6 rounded-xl border border-blue-100 dark:border-gray-700 shadow-sm transition-colors duration-300">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Kommentar schreiben
                </h3>

                {{-- Flash Messages mit wire:key --}}
                @if (session()->has('comment_success'))
                    <div wire:key="alert-success" class="mb-4 p-3 bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg text-sm transition-colors duration-300">
                        {{ session('comment_success') }}
                    </div>
                @endif

                @if (session()->has('comment_pending'))
                    <div wire:key="alert-pending" class="mb-4 p-3 bg-yellow-100 dark:bg-yellow-900 border border-yellow-300 dark:border-yellow-700 text-yellow-700 dark:text-yellow-200 rounded-lg text-sm transition-colors duration-300">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('comment_pending') }}
                        </div>
                    </div>
                @endif

                @if (session()->has('comment_blocked'))
                    <div wire:key="alert-blocked" class="mb-4 p-3 bg-red-100 dark:bg-red-900 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-200 rounded-lg text-sm transition-colors duration-300">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            {{ session('comment_blocked') }}
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="store" class="space-y-4">
                    <div>
                        <label for="authorName" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Name (optional)</label>
                        <input wire:model.defer="authorName" type="text" id="authorName" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300" placeholder="Dein Name (wird öffentlich angezeigt)" maxlength="50">
                        @error('authorName') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nachricht <span class="text-red-500 dark:text-red-400">*</span></label>
                        <input wire:model.defer="message" type="text" id="message" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-300" placeholder="Schreibe einen Kommentar... (max 150 Zeichen)" required maxlength="150"
                               x-on:keydown.enter.prevent="if (!showFirstUseNotice) { $wire.store() }">
                        @error('message') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div x-show="showFirstUseNotice" x-transition class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/30 dark:text-amber-200">
                        <p class="font-semibold">Hinweis zur Kommentarnutzung</p>
                        <p class="mt-1">
                            Bitte keine beleidigenden, diskriminierenden, bedrohenden oder anstößigen Inhalte posten.
                            Spam, bewusste Umgehung der Moderation und Manipulationsversuche sind nicht erlaubt.
                        </p>
                        <p class="mt-1 font-semibold">
                            Jegliche Verstöße können rechtliche Konsequenzen nach sich ziehen.
                        </p>
                        <p class="mt-1">
                            Details: <a href="{{ route('legal.terms') }}" class="underline underline-offset-2 hover:text-amber-700 dark:hover:text-amber-100">Nutzungsbedingungen</a>
                        </p>
                        <div class="mt-2">
                            <button type="button" @click="hideFirstUseNotice()"
                                    class="inline-flex items-center rounded-md border border-amber-300 bg-white px-2.5 py-1 font-medium text-amber-900 hover:bg-amber-100 dark:border-amber-800 dark:bg-amber-900/30 dark:text-amber-100 dark:hover:bg-amber-900/50">
                                Verstanden
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500 dark:text-gray-400" x-text="($wire.message ? $wire.message.length : 0) + '/150'"></span>

                        {{-- HIER WURDE wire:target="store" HINZUGEFÜGT --}}
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 dark:bg-blue-700 text-white font-medium rounded-lg hover:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5"
                                :disabled="showFirstUseNotice"
                                :class="{ 'opacity-50 cursor-not-allowed hover:shadow-none hover:translate-y-0': showFirstUseNotice }"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                wire:target="store">

                            <span wire:loading.remove wire:target="store">
                                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2"/>
                                </svg>
                            </span>

                            <span wire:loading wire:target="store">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>

                            <span wire:loading.remove wire:target="store">Senden</span>
                            <span wire:loading wire:target="store">Sende...</span>
                        </button>
                    </div>
                    <p x-show="showFirstUseNotice" class="text-xs text-amber-700 dark:text-amber-300">
                        Bitte zuerst den Hinweis mit „Verstanden“ bestätigen.
                    </p>
                </form>
            </div>
        @endif

        {{-- 2. KOMMENTARE DEAKTIVIERT MELDUNG --}}
        @if(!$commentsEnabled)
            <div class="mb-8 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-6 rounded-xl border border-gray-300 dark:border-gray-700 shadow-sm transition-colors duration-300">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Kommentare deaktiviert</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Die Kommentarfunktion wurde vom Administrator vorübergehend deaktiviert.</p>
                </div>
            </div>
        @endif

        {{-- 3. COOKIE BLOCKER MELDUNG --}}
        <div x-show="!moderationAllowed && {{ $commentsEnabled ? 'true' : 'false' }}" style="display: none;" class="mb-8 bg-gradient-to-r from-orange-50 to-red-50 dark:from-gray-800 dark:to-gray-900 p-6 rounded-xl border border-orange-200 dark:border-gray-700 shadow-sm transition-colors duration-300">
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Cookie-Einstellungen erforderlich</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4 text-sm leading-relaxed">
                    Um Kommentare zu schreiben, müssen Sie Moderation-Cookies akzeptieren.
                </p>
                <button onclick="document.cookie='{{ config('cookie-consent.cookie_name') }}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'; window.location.reload();"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 dark:bg-orange-700 text-white font-medium rounded-lg hover:bg-orange-700 dark:hover:bg-orange-800 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Cookie-Einstellungen öffnen
                </button>
            </div>
        </div>

    </div> {{-- Ende Alpine Wrapper --}}

    {{-- 4. KOMMENTARLISTE (Außerhalb des Alpine Wrappers, aber innerhalb des Root Livewire Divs) --}}
    @if(isset($comments) && $comments->count() > 0)
        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2" wire:poll.15s>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z" />
                    </svg>
                    Kommentare ({{ $totalComments }})
                </h3>
                @auth
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                        <a href="{{ route('moderation.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 dark:bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-300 shadow-sm hover:shadow-md">
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
                    {{-- WICHTIG: wire:key hinzufügen --}}
                    <div wire:key="comment-{{ $comment->id }}" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2 flex-grow">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ strtoupper(substr($comment->author_name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 dark:text-gray-100 text-sm">{{ $comment->author_name ?? 'Anonym' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
                                    <button wire:click="destroy({{ $comment->id }})" wire:confirm="Kommentar von {{ $comment->author_name ?? 'Anonym' }} wirklich löschen?" class="ml-2 text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-300 p-1 rounded hover:bg-red-100 dark:hover:bg-red-900 flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            @endauth
                        </div>
                        <p class="text-gray-700 dark:text-gray-200 break-words leading-relaxed">{{ $comment->message }}</p>
                    </div>
                @endforeach

                @if($hasMoreComments || $commentsToShow > 5)
                    <div class="text-center py-4 space-y-3">
                        @if($hasMoreComments)
                            <button wire:click="loadMore"
                                    class="inline-flex items-center gap-2 px-6 py-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm bg-blue-50 dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-300"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50"
                                    wire:target="loadMore">

                                <span wire:loading.remove wire:target="loadMore">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                </span>

                                <span wire:loading wire:target="loadMore">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </span>

                                <span wire:loading.remove wire:target="loadMore">Mehr laden</span>
                                <span wire:loading wire:target="loadMore">Lade...</span>
                            </button>
                        @endif

                        @if($commentsToShow > 5)
                            <div>
                                <button wire:click="showLess" class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200 font-medium text-sm bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>
                                    Nur die neuesten 5 anzeigen
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @elseif(!$commentsEnabled)
        {{-- Nichts tun, oben abgedeckt --}}
    @else
        <div class="text-center py-8 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="text-gray-600 dark:text-gray-300 font-medium">Noch keine Kommentare vorhanden</p>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Sei der Erste!</p>
        </div>
    @endif
</div>
