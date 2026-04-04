import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

const reverbKey = import.meta.env.VITE_REVERB_APP_KEY;
if (reverbKey) {
    const scheme = import.meta.env.VITE_REVERB_SCHEME || 'https';
    const host = import.meta.env.VITE_REVERB_HOST || window.location.hostname;
    const port = Number(import.meta.env.VITE_REVERB_PORT || (scheme === 'https' ? 443 : 80));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: reverbKey,
        wsHost: host,
        wsPort: port,
        wssPort: port,
        forceTLS: scheme === 'https',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/broadcasting/auth',
        auth: csrfToken ? { headers: { 'X-CSRF-TOKEN': csrfToken } } : undefined,
    });
}
