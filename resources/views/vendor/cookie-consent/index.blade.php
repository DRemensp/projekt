@unless ($alreadyConsentedWithCookies)
    <!-- Cookie Banner - Zentriert mit ausgegrauten Hintergrund -->
    <div id="cookieConsent" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4">
        <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full mx-4">
            <div class="p-6">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl"></span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Cookie-Einstellungen</h2>
                </div>

                <p class="text-gray-700 text-sm text-center mb-6 leading-relaxed">
                    Wir verwenden Cookies, um die Funktionalität unserer Website zu gewährleisten und eine spam- und missbrauchsfreie Umgebung für alle Nutzer zu schaffen.
                </p>

                <!-- 3 Buttons: Einstellungen, Nur Notwendige, Alles Akzeptieren -->
                <div class="flex flex-col gap-3">
                    <button id="cookieSettings"
                            class="w-full px-4 py-3 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-all duration-200 text-sm font-medium">
                        ⚙️ Einstellungen
                    </button>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="window.cookies.acceptNecessary()"
                                class="flex-1 px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm font-medium">
                            Nur Notwendige
                        </button>
                        <button onclick="window.cookies.acceptAll()"
                                class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm font-medium">
                            Alles Akzeptieren
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookie-Einstellungen Modal -->
    <div id="cookieModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[10000] hidden p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto mx-4">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Cookie-Einstellungen</h2>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <!-- Verpflichtende Cookies -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900">Erforderliche Cookies</h3>
                        <div class="w-10 h-6 bg-gray-400 rounded-full relative">
                            <div class="w-4 h-4 bg-gray-600 rounded-full absolute right-1 top-1"></div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">
                        Diese Cookies sind für die Grundfunktionen der Website erforderlich und können nicht deaktiviert werden.
                        Sie speichern Ihre Login-Informationen, Sicherheitstoken und grundlegende Webseiteneinstellungen.
                    </p>
                </div>

                <!-- Moderation -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900">Moderation</h3>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="moderationCookies" class="sr-only peer" checked>
                            <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-4 peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <p class="text-sm text-gray-600">
                        Bei Deaktivierung werden Kommentar-Sektionen und weitere interaktive Funktionen gesperrt,
                        was Ihr Website-Erlebnis beeinträchtigt.
                    </p>
                </div>

                <!-- Analytics -->
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-medium text-gray-900">Analytics</h3>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="analyticsCookies" class="sr-only peer">
                            <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-4 peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <p class="text-sm text-gray-600">
                        Erfasst Nutzerverhalten sowie Interaktionen auf der Website zur Verbesserung unserer Dienste.
                    </p>
                </div>
            </div>

            <div class="p-6 border-t bg-gray-50 flex flex-col sm:flex-row justify-end gap-3">
                <button onclick="window.cookies.acceptNecessary()"
                        class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-100 transition-all duration-200">
                    Nur Notwendige
                </button>
                <button id="saveSettings"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all duration-200">
                    Einstellungen Speichern
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.cookies = {
                // Nur Notwendige: Necessary + Moderation (für Kommentare)
                acceptNecessary: function() {
                    this.setCookiePreferences({
                        necessary: true,
                        moderation: false,  //  Für Kommentar-Funktion
                        analytics: false   // ❌ Kein Analytics
                    });
                    this.hideBanner();
                    this.triggerCommentUpdate(); //  NEU: Kommentar-Update
                },

                // Alles Akzeptieren: Alle Cookies
                acceptAll: function() {
                    this.setCookiePreferences({
                        necessary: true,
                        moderation: true,
                        analytics: true    // ✅ Analytics auch
                    });
                    this.hideBanner();
                    this.triggerCommentUpdate(); //  NEU: Kommentar-Update
                },

                // Legacy-Funktion für Kompatibilität
                accept: function() {
                    this.acceptAll();
                },

                reject: function() {
                    this.setCookiePreferences({
                        necessary: true,
                        moderation: false,
                        analytics: false
                    });
                    this.hideBanner();
                    this.triggerCommentUpdate(); //  NEU: Kommentar-Update
                },

                setCookiePreferences: function(preferences) {
                    const expires = new Date();
                    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
                    document.cookie = `laravel_cookie_consent=${JSON.stringify(preferences)}; expires=${expires.toUTCString()}; path=/`;

                    console.log('Cookie-Einstellungen gespeichert:', preferences);
                },

                hideBanner: function() {
                    const banner = document.getElementById('cookieConsent');
                    const modal = document.getElementById('cookieModal');
                    if (banner) banner.style.display = 'none';
                    if (modal) modal.classList.add('hidden');
                },

                //  NEU: Update Kommentar-Anzeige sofort
                triggerCommentUpdate: function() {
                    // Event für Kommentar-Updates triggern
                    window.dispatchEvent(new CustomEvent('cookiePreferencesUpdated'));
                }
            };

            // Event Listeners
            document.getElementById('cookieSettings').addEventListener('click', function() {
                document.getElementById('cookieModal').classList.remove('hidden');
            });

            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('cookieModal').classList.add('hidden');
            });

            document.getElementById('saveSettings').addEventListener('click', function() {
                const preferences = {
                    necessary: true,
                    moderation: document.getElementById('moderationCookies').checked,
                    analytics: document.getElementById('analyticsCookies').checked
                };

                window.cookies.setCookiePreferences(preferences);
                window.cookies.hideBanner();
                window.cookies.triggerCommentUpdate(); //  NEU: Kommentar-Update
            });

            // Modal schließen bei Klick außerhalb
            document.getElementById('cookieModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Escape-Taste für Modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('cookieModal');
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                    }
                }
            });
        });
    </script>
@endunless
