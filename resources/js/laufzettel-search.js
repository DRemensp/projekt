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
    const initialMessage = '<p class="text-center text-gray-500 dark:text-slate-400 italic py-4">Bitte gib einen Teamnamen ein, um zu suchen.</p>';
    const noResultsMessage = '<p class="text-center text-gray-500 dark:text-slate-400 italic py-4">Keine Teams gefunden, die dem Suchbegriff entsprechen.</p>';

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

    // Toggle Bonus Funktion
    function toggleBonus(teamId, buttonElement) {
        const team = allTeamsData.find(t => t.id === teamId);
        if (!team) return;

        // Button visuell deaktivieren während der Anfrage
        buttonElement.disabled = true;
        const originalContent = buttonElement.innerHTML;
        buttonElement.innerHTML = '<span class="animate-spin">⏳</span>';

        fetch(`/team/${teamId}/toggle-bonus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Lokale Daten aktualisieren
                    team.bonus = data.bonus;

                    // Button-Status aktualisieren
                    if (data.bonus) {
                        buttonElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 hover:bg-green-200 dark:bg-emerald-500/20 dark:text-emerald-200 dark:border-emerald-400/40 dark:hover:bg-emerald-500/30 transition-colors cursor-pointer';
                        buttonElement.innerHTML = '✅ Bonus';
                    } else {
                        buttonElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200 hover:bg-gray-200 dark:bg-slate-500/15 dark:text-slate-200 dark:border-slate-500/40 dark:hover:bg-slate-500/25 transition-colors cursor-pointer';
                        buttonElement.innerHTML = '⭕ Kein Bonus';
                    }

                    // Kurze Bestätigungsanimation
                    const card = buttonElement.closest('.team-card');
                    if (card) {
                        card.style.backgroundColor = data.bonus ? '#dcfce7' : '#fef3c7';
                        setTimeout(() => {
                            card.style.backgroundColor = '';
                        }, 300);
                    }
                } else {
                    alert('Fehler beim Aktualisieren des Bonus-Status');
                    buttonElement.innerHTML = originalContent;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Aktualisieren des Bonus-Status');
                buttonElement.innerHTML = originalContent;
            })
            .finally(() => {
                buttonElement.disabled = false;
            });
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

                // Bonus Button HTML - nur für Admins
                let bonusButtonHtml = '';
                if (typeof isAdmin !== 'undefined' && isAdmin) {
                    const bonusButtonClass = team.bonus
                        ? 'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 hover:bg-green-200 dark:bg-emerald-500/20 dark:text-emerald-200 dark:border-emerald-400/40 dark:hover:bg-emerald-500/30 transition-colors cursor-pointer'
                        : 'px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200 hover:bg-gray-200 dark:bg-slate-500/15 dark:text-slate-200 dark:border-slate-500/40 dark:hover:bg-slate-500/25 transition-colors cursor-pointer';

                    const bonusButtonText = team.bonus ? '✅ Bonus' : '⭕ Kein Bonus';

                    bonusButtonHtml = `
                        <button class="${bonusButtonClass}"
                                onclick="toggleBonus(${team.id}, this)">
                            ${bonusButtonText}
                        </button>
                    `;
                } else if (team.bonus) {
                    // Für Nicht-Admins: Bonus-Status nur anzeigen (nicht klickbar)
                    bonusButtonHtml = `
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 dark:bg-emerald-500/20 dark:text-emerald-200 dark:border-emerald-400/40">
                            ✅ Bonus
                        </span>
                    `;
                }

                resultsHtml += `
                    <div class="team-card bg-white night-card rounded-lg shadow-md p-4 hover:${hoverClass} hover:shadow-lg dark:hover:bg-slate-800/70 transition-all duration-200 border border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="flex-1 cursor-pointer" onclick="selectTeam(${team.id})">
                                <h3 class="text-lg font-semibold ${textClass}">${escapeHtml(team.name)}</h3>
                                <p class="text-sm text-gray-600 dark:text-slate-400">
                                    ${escapeHtml(team.klasse_name)} - ${escapeHtml(team.school_name)}
                                </p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <!-- Bonus Button/Anzeige -->
                                ${bonusButtonHtml}
                                <!-- Pfeil für Team-Auswahl -->
                                <div class="text-blue-600 dark:text-sky-300 cursor-pointer" onclick="selectTeam(${team.id})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            resultsHtml += `</div>`;
            resultsContainer.innerHTML = resultsHtml;
        }
    }

    // Globale Funktionen für Team-Auswahl und Bonus-Toggle
    if (!window.selectTeam) {
        window.selectTeam = function(teamId) {
            window.location.href = `/laufzettel/${teamId}`;
        };
    }

    if (!window.toggleBonus) {
        window.toggleBonus = toggleBonus;
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
