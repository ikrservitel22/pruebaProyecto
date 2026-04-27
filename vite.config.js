// Configuración de Vite para el proyecto Laravel
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        // Plugin de Laravel para Vite - maneja la compilación de assets
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // Archivos de entrada
            refresh: true, // Recarga automática en desarrollo
        }),
        // Plugin de Tailwind CSS
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'], // Ignorar vistas compiladas
        },
    },
});
