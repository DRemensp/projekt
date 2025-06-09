// resources/js/ranking-search.js

document.addEventListener('DOMContentLoaded', () => {

    // DOM-Elemente holen (nur wenn sie existieren)
    const searchInput = document.getElementById('team-search-input');
    const resultsContainer = document.getElementById('team-search-results');

    // Prüfen, ob die Elemente und Daten auf der Seite vorhanden sind
    if (!searchInput || !resultsContainer || typeof allTeamsData === 'undefined' || typeof colorMap === 'undefined') {
        return; // Skript beenden, wenn etwas fehlt
    }

    // Nachrichten-Templates
    const initialMessage = '<p class="text-center text-gray-500 italic py-4">Bitte gib einen Suchbegriff ein, um Teams zu finden.</p>';
    const noResultsMessage = '<p class="text-center text-gray-500 italic py-4">Keine Teams gefunden, die dem Suchbegriff entsprechen.</p>';

    // Funktion zum Abrufen der Farbklassen (JS-Version)
    function getJsSchoolColorClasses(schoolId) {
        const id = Number(schoolId) || 0;
        return colorMap[id] || colorMap['default'];
    }

    // Funktion zum sicheren HTML-Escaping (verhindert XSS)
    function escapeHtml(unsafe) {
        if (unsafe === null || typeof unsafe === 'undefined') {
            return '';
        }
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Suchfunktion
    function filterAndDisplayTeams() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        // Wenn Suchfeld leer ist, initialen Zustand anzeigen
        if (searchTerm === '') {
            resultsContainer.innerHTML = initialMessage;
            return;
        }

        // Teams filtern
        const filteredTeams = allTeamsData.filter(team =>
            team.name.toLowerCase().includes(searchTerm)
        );

        // Ergebnisse anzeigen
        if (filteredTeams.length === 0) {
            resultsContainer.innerHTML = noResultsMessage;
        } else {
            // Tabelle für Ergebnisse erstellen
            let tableHtml = `
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Klasse</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Schule</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Disziplinen</th>
                            <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gesamtpunkte</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
            `;

            // Sortiere gefilterte Teams nach Score (absteigend)
            filteredTeams.sort((a, b) => b.score - a.score);

            // Tabellenzeilen generieren
            filteredTeams.forEach((team, index) => {
                const colors = getJsSchoolColorClasses(team.school_id);
                // KORREKTUR: Bindestrich-Notation für JavaScript verwenden
                const hoverClass = colors['bg-light'] ? escapeHtml(colors['bg-light']) : 'bg-gray-50/60';
                const textClass = colors.text ? escapeHtml(colors.text) : 'text-gray-700';
                const pointsClass = colors['text-points'] ? escapeHtml(colors['text-points']) : 'text-gray-800';

                // Disziplinen sicher ausgeben
                const disciplinesHtml = team.disciplines_list
                    ? `<span class="text-xs">${escapeHtml(team.disciplines_list)}</span>`
                    : '<span class="text-gray-400 italic">-</span>';

                tableHtml += `
                    <tr class="hover:${hoverClass}">
                        <td class="py-3 px-4 text-sm text-gray-500">${index + 1}</td>
                        <td class="py-3 px-4 text-sm font-medium ${textClass}">${escapeHtml(team.name)}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">${escapeHtml(team.klasse_name)}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">${escapeHtml(team.school_name)}</td>
                        <td class="py-3 px-4 text-sm text-gray-700">${disciplinesHtml}</td>
                        <td class="py-3 px-4 text-sm font-semibold ${pointsClass}">${escapeHtml(team.score)}</td>
                    </tr>
                `;
            });

            tableHtml += `</tbody></table>`;
            resultsContainer.innerHTML = tableHtml;
        }
    }

    // Event Listener hinzufügen (bei jeder Eingabe filtern)
    searchInput.addEventListener('input', filterAndDisplayTeams);

    // Initialen Zustand beim Laden setzen
    resultsContainer.innerHTML = initialMessage;

});
