import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/navbar.js',
                'resources/js/laufzettel-search.js',
                'resources/js/teacher-scores.js',
                'resources/js/admin-carousel.js',
            ],
            refresh: true,
        }),
    ],
});


