<x-layout>
    <section class="max-w-4xl mx-auto px-4 py-10 sm:py-14">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Cookie-Richtlinie</h1>
        <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">
            Stand: {{ now()->format('d.m.Y') }}
        </p>

        <div class="mt-8 space-y-6 text-sm leading-relaxed text-gray-700 dark:text-gray-200">
            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">1. Was sind Cookies</h2>
                <p class="mt-2">
                    Cookies sind kleine Textdateien, die im Browser gespeichert werden und Einstellungen oder Zustände einer Website enthalten.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">2. Eingesetzte Cookie-Kategorien</h2>
                <ul class="mt-2 list-disc pl-5 space-y-1">
                    <li><strong>Erforderlich:</strong> Für Grundfunktionen, Sicherheit und stabilen Betrieb der Website.</li>
                    <li><strong>Moderation (optional):</strong> Aktiviert die Kommentarfunktion und den Schutz vor missbräuchlichen Inhalten.</li>
                    <li><strong>Analytics (optional):</strong> Ist als Option vorbereitet und dient bei Aktivierung der Verbesserung der Website durch statistische Auswertungen.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">3. Einwilligung und Widerruf</h2>
                <p class="mt-2">
                    Optionale Cookies werden nur nach Einwilligung gesetzt. Die Auswahl kann jederzeit über „Cookie-Präferenzen ändern“ im Footer angepasst oder widerrufen werden.
                </p>
                <p class="mt-2">
                    Ohne Einwilligung in Moderation bleiben Kommentare deaktiviert.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">4. Speicherdauer</h2>
                <p class="mt-2">
                    Die Cookie-Einstellungen werden derzeit für bis zu 365 Tage gespeichert, sofern sie nicht zuvor gelöscht oder geändert werden.
                </p>
            </section>
        </div>
    </section>
</x-layout>
