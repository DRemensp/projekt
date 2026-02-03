let adminBroadcastSubscribed = false;
let adminBroadcastTimer = null;

function getUserRoles() {
    const roles = document.body?.dataset?.roles || '';
    return roles
        .split(',')
        .map((role) => role.trim())
        .filter((role) => role.length > 0);
}

function showAdminBroadcast(message) {
    const popup = document.getElementById('adminBroadcastPopup');
    if (!popup) {
        return;
    }

    const messageEl = popup.querySelector('[data-admin-broadcast-message]');
    const closeBtn = popup.querySelector('[data-admin-broadcast-close]');
    const timerEl = popup.querySelector('[data-admin-broadcast-timer]');

    if (messageEl) {
        messageEl.textContent = message;
    }

    popup.classList.remove('hidden');

    if (adminBroadcastTimer) {
        clearInterval(adminBroadcastTimer);
        adminBroadcastTimer = null;
    }

    let remaining = 5;
    if (timerEl) {
        timerEl.textContent = `(${remaining})`;
    }

    if (closeBtn) {
        closeBtn.disabled = true;
        closeBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }

    adminBroadcastTimer = setInterval(() => {
        remaining -= 1;
        if (timerEl) {
            timerEl.textContent = remaining > 0 ? `(${remaining})` : '';
        }
        if (remaining <= 0) {
            clearInterval(adminBroadcastTimer);
            adminBroadcastTimer = null;
            if (closeBtn) {
                closeBtn.disabled = false;
                closeBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }, 1000);

    if (closeBtn && !closeBtn.dataset.bound) {
        closeBtn.addEventListener('click', () => {
            popup.classList.add('hidden');
        });
        closeBtn.dataset.bound = '1';
    }
}

function subscribeAdminBroadcasts() {
    if (adminBroadcastSubscribed) {
        return;
    }

    if (!window.Echo) {
        return;
    }

    adminBroadcastSubscribed = true;

    const isAuthed = document.body?.dataset?.auth === '1';
    const roles = getUserRoles();

    const handler = (payload) => {
        if (payload?.message) {
            showAdminBroadcast(payload.message);
        }
    };

    if (!isAuthed) {
        window.Echo.channel('admin-message.guests')
            .listen('.admin.message', handler);
        return;
    }

    if (roles.includes('teacher')) {
        window.Echo.private('admin-message.teachers')
            .listen('.admin.message', handler);
    }

    if (!roles.includes('teacher') && !roles.includes('admin')) {
        window.Echo.private('admin-message.klasses')
            .listen('.admin.message', handler);
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', subscribeAdminBroadcasts);
} else {
    subscribeAdminBroadcasts();
}

document.addEventListener('livewire:navigated', subscribeAdminBroadcasts);
