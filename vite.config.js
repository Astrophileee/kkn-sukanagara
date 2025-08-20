import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        allowedHosts: [
            'c282161b-2250-4e14-9560-6a79e15ff589-00-3koa3cgr4kjma.sisko.replit.dev'
        ],
        hmr: {
            host: 'c282161b-2250-4e14-9560-6a79e15ff589-00-3koa3cgr4kjma.sisko.replit.dev',
            protocol: 'wss',
        },
        watch: {
            usePolling: true,
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/submissions.js'
            ],
            refresh: true,
        }),
    ],
});
