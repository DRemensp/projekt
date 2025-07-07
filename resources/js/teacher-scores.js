// resources/js/teacher-scores.js
function initTeacherScores() {
    // Prüfen, ob die benötigten Daten vorhanden sind
    if (typeof window.allScoresData === 'undefined') {
        return;
    }

    // Referenzen zu den DOM-Elementen holen
    const disciplineSelect = document.getElementById('discipline_id_select');
    const teamSelect = document.getElementById('team_id_select');
    const score1Input = document.getElementById('score_1_input');
    const score2Input = document.getElementById('score_2_input');
    const score1Display = document.getElementById('loaded_score_1_display');
    const score2Display = document.getElementById('loaded_score_2_display');

    // Prüfen ob alle Elemente vorhanden sind
    if (!disciplineSelect || !teamSelect || !score1Input || !score2Input) {
        return;
    }

    // Prüfen ob bereits initialisiert
    if (disciplineSelect.hasAttribute('data-scores-initialized')) return;
    disciplineSelect.setAttribute('data-scores-initialized', 'true');

    // Sicherstellen, dass die Span-Elemente existieren, bevor auf textContent zugegriffen wird
    const score1DisplayText = score1Display ? score1Display.querySelector('span:last-child') : null;
    const score2DisplayText = score2Display ? score2Display.querySelector('span:last-child') : null;

    // Funktion zum Aktualisieren der Score-Felder und der Anzeige
    function updateScoresDisplay() {
        // Aktuelle Werte aus den Dropdowns holen
        const selectedDisciplineId = disciplineSelect.value;
        const selectedTeamId = teamSelect.value;

        // Standardmäßig Anzeigen zurücksetzen
        if (score1Display) score1Display.style.display = 'none';
        if (score2Display) score2Display.style.display = 'none';
        if (score1DisplayText) score1DisplayText.textContent = '';
        if (score2DisplayText) score2DisplayText.textContent = '';

        // Prüfen, ob beides ausgewählt ist
        if (selectedDisciplineId && selectedTeamId) {
            const key = selectedDisciplineId + '_' + selectedTeamId;
            // Scores aus dem globalen Objekt holen
            const currentScores = window.allScoresData[key] || null; // Fallback auf null

            let dbScore1 = ''; // Default leer
            let dbScore2 = ''; // Default leer

            if (currentScores) {
                // Werte aus DB merken (oder null konvertieren zu leerem String für Input)
                dbScore1 = currentScores.score_1 !== null ? String(currentScores.score_1) : '';
                dbScore2 = currentScores.score_2 !== null ? String(currentScores.score_2) : '';

                // Optional: Zeige die "Aktuell gespeichert"-Werte an, wenn nicht null
                if (score1Display && score1DisplayText && currentScores.score_1 !== null) {
                    score1DisplayText.textContent = currentScores.score_1;
                    score1Display.style.display = 'block';
                }
                if (score2Display && score2DisplayText && currentScores.score_2 !== null) {
                    score2DisplayText.textContent = currentScores.score_2;
                    score2Display.style.display = 'block';
                }
            }

            // Setze die Input-Werte IMMER auf die (ggf. leeren) DB-Werte.
            score1Input.value = dbScore1;
            score2Input.value = dbScore2;

        } else {
            // Wenn Auswahl unvollständig ist, Felder leeren
            score1Input.value = '';
            score2Input.value = '';
        }
    }

    // Event Listener zu den Dropdowns hinzufügen
    disciplineSelect.addEventListener('change', updateScoresDisplay);
    teamSelect.addEventListener('change', updateScoresDisplay);

    // Initial einmal aufrufen, um Scores für evtl. per old() vorausgewählte Kombination zu laden
    updateScoresDisplay();
}

// Initialisierung nach DOM-Laden oder sofort wenn bereits geladen
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTeacherScores);
} else {
    initTeacherScores();
}
