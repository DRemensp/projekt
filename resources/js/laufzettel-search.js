// resources/js/laufzettel-search.js
function initLaufzettelSearch() {
    // DOM-Elemente holen (nur wenn sie existieren)
    const searchInput = document.getElementById('team-search-input');
    const resultsContainer = document.getElementById('team-search-results');

    // Prüfen, ob die Elemente und Daten auf der Seite vorhanden sind
    if (!searchInput || !resultsContainer || typeof allTeamsData === 'undefined' || typeof colorMap === 'undefined') {
        return; // Skript beenden, wenn etwas fehlt
    }

    // Prüfen ob bereits initialisiert
    if (searchInput.hasAttribute('data-search-initialized')) return;
    searchInput.setAttribute('data-search-initialized', 'true');

    // Nachrichten-Templates
    const initialMessage = '<p class="text-center text-gray-500 italic py-4">Bitte gib einen Teamnamen ein, um zu suchen.</p>';
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
            // Container für Ergebnisse erstellen
            let resultsHtml = `<div class="space-y-3">`;

            // Team-Cards generieren
            filteredTeams.forEach((team) => {
                const colors = getJsSchoolColorClasses(team.school_id);
                const hoverClass = colors['bg-light'] ? escapeHtml(colors['bg-light']) : 'bg-gray-50/60';
                const textClass = colors.text ? escapeHtml(colors.text) : 'text-gray-700';

                resultsHtml += `
                    <div class="bg-white rounded-lg shadow-md p-4 hover:${hoverClass} hover:shadow-lg transition-all duration-200 cursor-pointer border border-gray-200"
                         onclick="selectTeam(${team.id})">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold ${textClass}">${escapeHtml(team.name)}</h3>
                                <p class="text-sm text-gray-600">
                                    ${escapeHtml(team.klasse_name)} - ${escapeHtml(team.school_name)}
                                </p>
                            </div>
                            <div class="text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                `;
            });

            resultsHtml += `</div>`;
            resultsContainer.innerHTML = resultsHtml;
        }
    }

    // Globale Funktion für Team-Auswahl (nur einmal definieren)
    if (!window.selectTeam) {
        window.selectTeam = function(teamId) {
            window.location.href = `/laufzettel/${teamId}`;
        };
    }

    // Event Listener hinzufügen (bei jeder Eingabe filtern)
    searchInput.addEventListener('input', filterAndDisplayTeams);

    // Initialen Zustand beim Laden setzen
    resultsContainer.innerHTML = initialMessage;
}

// Initialisierung nach DOM-Laden oder sofort wenn bereits geladen
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLaufzettelSearch);
} else {
    initLaufzettelSearch();
}
