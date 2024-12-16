import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vitePluginRequire from "vite-plugin-require";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vitePluginRequire.default({
            // hasil build dari preline memanggil require tapi vite tidak mengenali require sehingga perlu di require ulang dengan vite-plugin-require
            fileRegex: /(.jsx?|.tsx?|.vue|.js)$/,
        }),
    ],
});
