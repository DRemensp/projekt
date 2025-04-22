// resources/js/teacher-scores.js

// Sicherstellen, dass das Skript erst nach dem Laden des DOMs ausgeführt wird
document.addEventListener('DOMContentLoaded', function () {

    // Prüfen, ob die benötigten Daten vorhanden sind
    if (typeof window.allScoresData === 'undefined') {
        console.error('Teacher Scores Error: allScoresData is not defined. Make sure it is set in the Blade template.');
        return; // Skript beenden, wenn Daten fehlen
    }

    // Referenzen zu den DOM-Elementen holen
    const disciplineSelect = document.getElementById('discipline_id_select');
    const teamSelect = document.getElementById('team_id_select');
    const score1Input = document.getElementById('score_1_input');
    const score2Input = document.getElementById('score_2_input');
    const score1Display = document.getElementById('loaded_score_1_display');
    const score2Display = document.getElementById('loaded_score_2_display');
    // Sicherstellen, dass die Span-Elemente existieren, bevor auf textContent zugegriffen wird
    const score1DisplayText = score1Display ? score1Display.querySelector('span:last-child') : null;
    const score2DisplayText = score2Display ? score2Display.querySelector('span:last-child') : null;

    // Funktion zum Aktualisieren der Score-Felder und der Anzeige
    function updateScoresDisplay() {
        // Prüfen, ob alle Elemente gefunden wurden
        if (!disciplineSelect || !teamSelect || !score1Input || !score2Input) {
            console.error('Teacher Scores Error: Could not find all required form elements.');
            return;
        }

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
            // Der `value`-Attribut im Blade hat nur den `old()`-Wert oder leer gesetzt.
            // Wenn der User hier was auswählt, wird der Input überschrieben.
            score1Input.value = dbScore1;
            score2Input.value = dbScore2;

        } else {
            // Wenn Auswahl unvollständig ist, Felder leeren (respektiert nicht mehr `old` für Scores)
            score1Input.value = '';
            score2Input.value = '';
        }
    }

    // Event Listener zu den Dropdowns hinzufügen (nur wenn Elemente existieren)
    if (disciplineSelect) {
        disciplineSelect.addEventListener('change', updateScoresDisplay);
    }
    if (teamSelect) {
        teamSelect.addEventListener('change', updateScoresDisplay);
    }

    // Initial einmal aufrufen, um Scores für evtl. per old() vorausgewählte Kombination zu laden
    updateScoresDisplay();

}); // Ende DOMContentLoaded
