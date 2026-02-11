let adminBroadcastSubscribed = false;
let adminBroadcastTimer = null;

// Hilfsfunktion: Rollen aus dem Body-Tag lesen
function getUserRoles() {
    const roles = document.body?.dataset?.roles || '';
    return roles
        .split(',')
        .map((role) => role.trim())
        .filter((role) => role.length > 0);
}

// Zeigt das Popup an (Sicher gegen XSS durch textContent)
function showAdminBroadcast(message) {
    const popup = document.getElementById('adminBroadcastPopup');
    if (!popup) return;

    const messageEl = popup.querySelector('[data-admin-broadcast-message]');
    const closeBtn = popup.querySelector('[data-admin-broadcast-close]');
    const timerEl = popup.querySelector('[data-admin-broadcast-timer]');

    // SICHERHEIT: textContent verhindert, dass HTML/JS ausgeführt wird
    if (messageEl) {
        messageEl.textContent = message;
    }

    // Modal sichtbar machen
    popup.classList.remove('hidden');

    // Alten Timer aufräumen
    if (adminBroadcastTimer) {
        clearInterval(adminBroadcastTimer);
        adminBroadcastTimer = null;
    }

    // Timer Logik (5 Sekunden Sperre)
    let remaining = 5;

    if (closeBtn) {
        closeBtn.disabled = true;
        closeBtn.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400', 'dark:bg-gray-600');
        closeBtn.classList.remove('bg-blue-600', 'hover:bg-blue-500');
    }

    if (timerEl) {
        timerEl.textContent = `(${remaining}s)`;
    }

    adminBroadcastTimer = setInterval(() => {
        remaining -= 1;

        if (timerEl) {
            timerEl.textContent = remaining > 0 ? `(${remaining}s)` : '';
        }

        if (remaining <= 0) {
            clearInterval(adminBroadcastTimer);
            adminBroadcastTimer = null;

            // Button freigeben
            if (closeBtn) {
                closeBtn.disabled = false;
                closeBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400', 'dark:bg-gray-600');
                closeBtn.classList.add('bg-blue-600', 'hover:bg-blue-500');
            }
        }
    }, 1000);

    // Schließen-Event (nur einmal binden)
    if (closeBtn && !closeBtn.dataset.bound) {
        closeBtn.addEventListener('click', () => {
            popup.classList.add('hidden');
        });
        closeBtn.dataset.bound = '1';
    }
}

function subscribeAdminBroadcasts() {
    // Verhindern, dass wir mehrfach abonnieren
    if (adminBroadcastSubscribed) return;
    if (!window.Echo) return; // Falls Echo noch nicht geladen ist

    adminBroadcastSubscribed = true;

    const isAuthed = document.body?.dataset?.auth === '1';
    const roles = getUserRoles();

    // Der Handler, der ausgeführt wird, wenn eine Nachricht reinkommt
    const handler = (payload) => {
        if (payload?.message) {
            showAdminBroadcast(payload.message);
        }
    };

    // --- LOGIK FÜR KANAL-AUSWAHL ---

    // 1. Fall: Gast (Nicht eingeloggt)
    if (!isAuthed) {
        console.log('Broadcast: Listening as Guest');
        window.Echo.channel('admin-message.guests')
            .listen('.admin.message', handler);
        return; // Fertig, Gäste hören keine anderen Kanäle
    }

    // 2. Fall: Admin
    if (roles.includes('admin')) {
        console.log('Broadcast: Admin mode - No listening (Sending only)');
        // Admin abonniert NICHTS. Er sieht nur seine Success-Meldung vom Controller.
        return;
    }

    // 3. Fall: Lehrer
    if (roles.includes('teacher')) {
        console.log('Broadcast: Listening as Teacher');
        window.Echo.private('admin-message.teachers')
            .listen('.admin.message', handler);
        // Lehrer hören NICHT auf 'guests', da "Guest" = "Nur ausgeloggte User"
        return;
    }

    // 4. Fall: Alle anderen (Schüler / Klasse)
    console.log('Broadcast: Listening as Class/Student');
    window.Echo.private('admin-message.klasses')
        .listen('.admin.message', handler);
}

// Initialisierung bei Seitenstart
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', subscribeAdminBroadcasts);
} else {
    subscribeAdminBroadcasts();
}

// Re-Initialisierung bei Livewire Navigation (SPA)
document.addEventListener('livewire:navigated', subscribeAdminBroadcasts);
