import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    build: {
        outDir: '.build/.vite',
    },
    plugins: [
        laravel([
            'resources/scss/app.scss',
            'resources/js/app.js',
        ]),
    ],
});
