@unless ($alreadyConsentedWithCookies)
    @php($consentCookieName = config('cookie-consent.cookie_name', 'laravel_cookie_consent'))
    <div id="cookieConsent" class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5">
        <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm"></div>
        <div class="relative mx-auto w-full max-w-[28rem] sm:max-w-[32rem]">
            <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white/95 shadow-[0_24px_60px_rgba(15,23,42,0.24)] backdrop-blur dark:border-slate-700/70 dark:bg-slate-900/95">
                <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-80">
                    <div class="absolute -right-10 -top-16 h-40 w-40 rounded-full bg-cyan-300/30 blur-3xl dark:bg-cyan-400/20"></div>
                    <div class="absolute -left-12 bottom-0 h-36 w-36 rounded-full bg-blue-300/30 blur-3xl dark:bg-blue-500/20"></div>
                </div>

                <div class="relative space-y-4 p-5 sm:p-6">
                    <div class="flex flex-col items-center text-center">
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h.008v.008H9.75V9.75zm4.5 0h.008v.008h-.008V9.75zM8.5 14.5c1.1.9 2.4 1.35 3.5 1.35s2.4-.45 3.5-1.35" />
                            </svg>
                        </div>
                        <h2 class="mt-3 text-lg font-bold tracking-tight text-slate-900 dark:text-white sm:text-xl">Datenschutz & Cookie-Einstellungen</h2>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                            Wir nutzen notwendige Cookies für den Betrieb. Optionale Cookies aktivieren Kommentare und helfen bei Statistiken.
                        </p>
                    </div>

                    <section class="rounded-2xl border border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-800/40">
                        <div class="text-left">
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Designmodus</h3>
                        </div>
                        <div class="mt-2">
                            <input id="themePreferenceSlider" type="range" min="0" max="2" step="1" value="1" class="w-full accent-blue-600">
                            <div class="mt-1 grid grid-cols-3 text-xs font-semibold text-slate-500 dark:text-slate-400">
                                <span class="text-left">Dark</span>
                                <span class="text-center">System</span>
                                <span class="text-right">Light</span>
                            </div>
                        </div>
                    </section>

                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <button onclick="window.cookies.acceptNecessary()"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-800 transition hover:bg-slate-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:bg-slate-700 dark:text-slate-100 dark:hover:bg-slate-600">
                            Nur notwendige
                        </button>
                        <button onclick="window.cookies.reject()"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                            Alle ablehnen
                        </button>
                        <button onclick="window.cookies.acceptAll()"
                                class="sm:col-span-2 inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Alle akzeptieren
                        </button>
                        <button id="cookieSettings"
                                class="sm:col-span-2 inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                            Einstellungen anpassen
                        </button>
                    </div>

                    <p class="text-center text-xs font-medium text-slate-500 dark:text-slate-400">
                        Ohne Auswahl bleibt die Seite gesperrt.
                    </p>
                    <p class="text-center text-xs text-slate-500 dark:text-slate-400">
                        <a href="{{ route('legal.privacy') }}" class="underline decoration-dotted underline-offset-2 hover:text-blue-600 dark:hover:text-blue-400">Datenschutz</a>
                        ·
                        <a href="{{ route('legal.cookies') }}" class="underline decoration-dotted underline-offset-2 hover:text-blue-600 dark:hover:text-blue-400">Cookie-Richtlinie</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="cookieModal" class="fixed inset-0 z-[10000] hidden" role="dialog" aria-modal="true" aria-labelledby="cookieModalTitle">
        <div id="cookieModalBackdrop" class="absolute inset-0 bg-slate-950/65 backdrop-blur-sm"></div>

        <div class="relative flex min-h-full items-center justify-center p-3 sm:p-4">
            <div class="w-full max-w-[28rem] overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5 dark:bg-slate-900 dark:ring-white/10 sm:max-w-[34rem]">
                <div class="border-b border-slate-200/80 px-4 py-4 sm:px-6 dark:border-slate-700/80">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-blue-600 dark:text-blue-400">Privatsphäre</p>
                            <h2 id="cookieModalTitle" class="mt-1 text-xl font-bold text-slate-900 dark:text-white">Cookie-Auswahl</h2>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">Lege fest, welche optionalen Cookies aktiviert werden dürfen.</p>
                        </div>
                        <button id="closeModal" type="button" aria-label="Schließen"
                                class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-slate-200 text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white">
                            <span class="text-2xl leading-none">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="max-h-[72vh] space-y-4 overflow-y-auto px-4 py-4 sm:px-6 sm:py-6">
                    <section class="rounded-2xl border border-emerald-200/90 bg-emerald-50/70 p-4 dark:border-emerald-900/70 dark:bg-emerald-950/40">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-bold text-emerald-900 dark:text-emerald-300">Erforderliche Cookies</h3>
                                <p class="mt-1 text-sm leading-relaxed text-emerald-800/90 dark:text-emerald-200/90">
                                    Immer aktiv, damit Anmeldung, Sicherheit und Grundfunktionen zuverlässig laufen.
                                </p>
                            </div>
                            <span class="shrink-0 rounded-full bg-emerald-600 px-3 py-1 text-xs font-semibold text-white">Aktiv</span>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-800/40">
                        <div class="flex items-start justify-between gap-4">
                            <div class="pr-2">
                                <h3 class="text-base font-semibold text-slate-900 dark:text-white">Moderation-Cookies</h3>
                                <p class="mt-1 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                                    Benötigt für Kommentar-Funktionen und Schutz vor Spam.
                                </p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center self-center">
                                <input type="checkbox" id="moderationCookies" class="peer sr-only">
                                <span class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-blue-600 dark:bg-slate-600"></span>
                                <span class="pointer-events-none absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                            </label>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-700 dark:bg-slate-800/40">
                        <div class="flex items-start justify-between gap-4">
                            <div class="pr-2">
                                <h3 class="text-base font-semibold text-slate-900 dark:text-white">Analytics-Cookies</h3>
                                <p class="mt-1 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                                    Hilft uns zu verstehen, welche Inhalte genutzt werden, damit wir die Seite verbessern.
                                </p>
                            </div>
                            <label class="relative inline-flex cursor-pointer items-center self-center">
                                <input type="checkbox" id="analyticsCookies" class="peer sr-only">
                                <span class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-blue-600 dark:bg-slate-600"></span>
                                <span class="pointer-events-none absolute left-1 top-1 h-4 w-4 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                            </label>
                        </div>
                    </section>
                </div>

                <div class="border-t border-slate-200/80 bg-slate-50 px-4 py-4 dark:border-slate-700/70 dark:bg-slate-900/70 sm:px-6">`r`n                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <button onclick="window.cookies.acceptNecessary()"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                            Nur notwendige
                        </button>
                        <button onclick="window.cookies.acceptAll()"
                                class="inline-flex items-center justify-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 dark:bg-slate-700 dark:hover:bg-slate-600">
                            Alle akzeptieren
                        </button>
                        <button id="saveSettings"
                                class="sm:col-span-2 inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Auswahl speichern
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cookieConsent = document.getElementById('cookieConsent');
            const scrollKeys = [' ', 'Spacebar', 'PageUp', 'PageDown', 'End', 'Home', 'ArrowUp', 'ArrowDown'];
            const preventLockedScroll = function(e) {
                if (!window.cookies || !window.cookies.isLocked) return;
                if (e.type === 'keydown' && !scrollKeys.includes(e.key)) return;
                e.preventDefault();
            };

            const themePreferenceSlider = document.getElementById('themePreferenceSlider');
            const readThemeChoice = function() {
                if (!themePreferenceSlider) return 'system';
                const value = Number(themePreferenceSlider.value);
                if (value === 0) return 'dark';
                if (value === 2) return 'light';
                return 'system';
            };

            const applyThemeChoice = function(choice) {
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (choice === 'dark') {
                    document.documentElement.classList.add('dark');
                } else if (choice === 'light') {
                    document.documentElement.classList.remove('dark');
                } else if (prefersDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            };

            const saveThemeChoice = function(choice) {
                localStorage.setItem('theme', choice);
            };

            const initThemeSlider = function() {
                if (!themePreferenceSlider) return;
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === null) {
                    localStorage.setItem('theme', 'system');
                }
                if (savedTheme === 'dark') themePreferenceSlider.value = '0';
                else if (savedTheme === 'light') themePreferenceSlider.value = '2';
                else themePreferenceSlider.value = '1';

                const choice = readThemeChoice();
                applyThemeChoice(choice);

                themePreferenceSlider.addEventListener('input', function() {
                    const liveChoice = readThemeChoice();
                    applyThemeChoice(liveChoice);
                });
            };

            window.cookies = {
                isLocked: false,

                lockUi: function() {
                    this.isLocked = true;
                    document.documentElement.style.overflow = 'hidden';
                    document.body.style.overflow = 'hidden';
                    document.body.style.touchAction = 'none';
                    window.addEventListener('wheel', preventLockedScroll, { passive: false });
                    window.addEventListener('touchmove', preventLockedScroll, { passive: false });
                    window.addEventListener('keydown', preventLockedScroll, { passive: false });
                },

                unlockUi: function() {
                    this.isLocked = false;
                    document.documentElement.style.overflow = '';
                    document.body.style.overflow = '';
                    document.body.style.touchAction = '';
                    window.removeEventListener('wheel', preventLockedScroll);
                    window.removeEventListener('touchmove', preventLockedScroll);
                    window.removeEventListener('keydown', preventLockedScroll);
                },

                acceptNecessary: function() {
                    const themeChoice = readThemeChoice();
                    saveThemeChoice(themeChoice);
                    applyThemeChoice(themeChoice);
                    this.setCookiePreferences({
                        necessary: true,
                        moderation: false,
                        analytics: false
                    });
                    this.hideBanner();
                    this.triggerCommentUpdate();
                },

                acceptAll: function() {
                    const themeChoice = readThemeChoice();
                    saveThemeChoice(themeChoice);
                    applyThemeChoice(themeChoice);
                    this.setCookiePreferences({
                        necessary: true,
                        moderation: true,
                        analytics: true
                    });
                    this.hideBanner();
                    this.triggerCommentUpdate();
                },

                accept: function() {
                    this.acceptAll();
                },

                reject: function() {
                    const themeChoice = readThemeChoice();
                    saveThemeChoice(themeChoice);
                    applyThemeChoice(themeChoice);
                    this.setCookiePreferences({
                        necessary: true,
                        moderation: false,
                        analytics: false
                    });
                    this.hideBanner();
                    this.triggerCommentUpdate();
                },

                setCookiePreferences: function(preferences) {
                    const expires = new Date();
                    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
                    const consent = {
                        ...preferences,
                        consentVersion: 1,
                        consentedAt: new Date().toISOString()
                    };
                    const secureFlag = window.location.protocol === 'https:' ? '; Secure' : '';
                    document.cookie = `{{ $consentCookieName }}=${encodeURIComponent(JSON.stringify(consent))}; expires=${expires.toUTCString()}; path=/; SameSite=Lax${secureFlag}`;
                },

                hideBanner: function() {
                    const banner = document.getElementById('cookieConsent');
                    const modal = document.getElementById('cookieModal');
                    this.unlockUi();
                    if (banner) banner.style.display = 'none';
                    if (modal) modal.classList.add('hidden');
                },

                triggerCommentUpdate: function() {
                    window.dispatchEvent(new CustomEvent('cookiePreferencesUpdated'));
                }
            };

            const cookieSettingsButton = document.getElementById('cookieSettings');
            const closeModalButton = document.getElementById('closeModal');
            const saveSettingsButton = document.getElementById('saveSettings');
            const cookieModal = document.getElementById('cookieModal');

            initThemeSlider();

            if (cookieConsent) {
                window.cookies.lockUi();
            }

            if (cookieSettingsButton && cookieModal) {
                cookieSettingsButton.addEventListener('click', function() {
                    cookieModal.classList.remove('hidden');
                });
            }

            if (closeModalButton && cookieModal) {
                closeModalButton.addEventListener('click', function() {
                    cookieModal.classList.add('hidden');
                });
            }

            if (saveSettingsButton) {
                saveSettingsButton.addEventListener('click', function() {
                    const themeChoice = readThemeChoice();
                    const preferences = {
                        necessary: true,
                        moderation: document.getElementById('moderationCookies').checked,
                        analytics: document.getElementById('analyticsCookies').checked
                    };

                    saveThemeChoice(themeChoice);
                    applyThemeChoice(themeChoice);
                    window.cookies.setCookiePreferences(preferences);
                    window.cookies.hideBanner();
                    window.cookies.triggerCommentUpdate();
                });
            }

            if (cookieModal) {
                cookieModal.addEventListener('click', function(e) {
                    if (e.target === cookieModal || e.target.id === 'cookieModalBackdrop') {
                        cookieModal.classList.add('hidden');
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && cookieModal && !cookieModal.classList.contains('hidden')) {
                    cookieModal.classList.add('hidden');
                }
            });
        });
    </script>
@endunless




