import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'resources/views/**/*.blade.php',
                'resources/js/**/*.vue',
                'resources/js/**/*.js',
                // Исключить проблемные папки
                '!public/pma/**',
            ],
        }),
    ],
    server: {
        watch: {
            ignored: [
                '**/public/pma/**', // Игнорировать phpMyAdmin
                '**/node_modules/**',
                '**/.git/**',
            ],
        },
        hmr: {
            host: 'localhost',
        },
        // Прокси для API (опционально)
        proxy: {
            '/api': 'http://localhost:8000',
            '/sanctum': 'http://localhost:8000',
            '/broadcasting': 'http://localhost:8000',
        }
    }
});