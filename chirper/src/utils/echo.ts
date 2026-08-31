import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Делаем Pusher доступным глобально, так как Echo ищет его в window
declare global {
    interface Window {
        Pusher: typeof Pusher;
        Echo: Echo<'pusher'>;
    }
}

window.Pusher = Pusher;

export const echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY || 'my-app-key',
    wsHost: import.meta.env.VITE_REVERB_HOST || '127.0.0.1',
    wsPort: Number(import.meta.env.VITE_REVERB_PORT) || 8080,
    wssPort: Number(import.meta.env.VITE_REVERB_PORT) || 8080,
    forceTLS: false, // Локально используем ws:// вместо wss://
    enabledTransports: ['ws', 'wss'],
});
