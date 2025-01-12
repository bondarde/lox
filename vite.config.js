import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    build: {
        outDir: '.build/.vite',
    },
    plugins: [
        laravel(
            {
                input: [
                    'resources/scss/app.scss',
                    'resources/js/app.js',
                ],
                refresh: [
                    ...refreshPaths,
                    'app/Livewire/**',
                ],
            },
        ),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                api: 'modern'
            }
        }
    },
});
