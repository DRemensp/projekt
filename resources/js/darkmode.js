// Dark Mode Toggle - Sicher implementiert ohne XSS-Risiken
document.addEventListener('DOMContentLoaded', function() {
    const STORAGE_KEY = 'theme';
    const DARK_CLASS = 'dark';
    const LIGHT_VALUE = 'light';
    const DARK_VALUE = 'dark';

    // Initialisierung: Theme aus localStorage laden
    function initTheme() {
        try {
            const savedTheme = localStorage.getItem(STORAGE_KEY);
            const isDark = savedTheme === DARK_VALUE;

            if (isDark) {
                document.documentElement.classList.add(DARK_CLASS);
            } else {
                document.documentElement.classList.remove(DARK_CLASS);
            }

            updateToggleIcon(isDark);
        } catch (e) {
            // Fallback wenn localStorage nicht verfügbar ist
            console.warn('LocalStorage nicht verfügbar:', e);
        }
    }

    // Theme wechseln
    function toggleTheme() {
        const isDark = document.documentElement.classList.contains(DARK_CLASS);

        if (isDark) {
            document.documentElement.classList.remove(DARK_CLASS);
            safeSetStorage(LIGHT_VALUE);
            updateToggleIcon(false);
        } else {
            document.documentElement.classList.add(DARK_CLASS);
            safeSetStorage(DARK_VALUE);
            updateToggleIcon(true);
        }
    }

    // Sicheres Speichern im localStorage
    function safeSetStorage(value) {
        try {
            // Sanitize: nur erlaubte Werte speichern
            if (value === LIGHT_VALUE || value === DARK_VALUE) {
                localStorage.setItem(STORAGE_KEY, value);
            }
        } catch (e) {
            console.warn('Konnte Theme nicht speichern:', e);
        }
    }

    // Toggle Icon aktualisieren
    function updateToggleIcon(isDark) {
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');

        if (sunIcon && moonIcon) {
            if (isDark) {
                sunIcon.classList.remove('hidden');
                sunIcon.classList.add('flex');
                moonIcon.classList.add('hidden');
                moonIcon.classList.remove('flex');
            } else {
                sunIcon.classList.add('hidden');
                sunIcon.classList.remove('flex');
                moonIcon.classList.remove('hidden');
                moonIcon.classList.add('flex');
            }
        }
    }

    // Event Listener für Toggle Button
    const toggleButton = document.getElementById('darkModeToggle');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleTheme);
    }

    // Theme beim Laden initialisieren
    initTheme();
});
