import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        minify: 'terser',
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    server: {
        hmr: process.env.VITE_HMR_HOST
            ? {
                host: process.env.VITE_HMR_HOST,
                protocol: 'ws',
                port: 5173,
            }
            : true,
    },
});
