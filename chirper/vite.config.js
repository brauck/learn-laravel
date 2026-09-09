import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            //input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/app.tsx'],
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
        react(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        host: '0.0.0.0', // Позволяет подключаться к Vite извне контейнера
        hmr: {
            host: 'localhost', // Браузер на вашем ПК будет слать HMR-запросы на localhost
        },
    },
});
