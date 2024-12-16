import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import requireTransform from 'vite-plugin-require-transform';

export default defineConfig({
    plugins: [

        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        requireTransform({
        }),
    ],
});


