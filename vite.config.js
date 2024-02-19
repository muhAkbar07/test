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
        outDir: "dist", // Direktori output hasil build
        sourcemap: true, // Aktifkan sourcemaps
        manifest: true, // Aktifkan manifest.json
    },

    // Konfigurasi untuk mode produksi
    build: {
        outDir: "dist", // Direktori output hasil build
        minify: true, // Aktifkan minifikasi
        manifest: true, // Aktifkan manifest.json
    },

    // Konfigurasi lainnya
    plugins: [
        // Daftar plugin Vite yang akan digunakan
    ],

    // Konfigurasi server pengembangan
    server: {
        port: 3000, // Port server
        open: true, // Buka browser otomatis saat server dijalankan
    },

    // Konfigurasi lainnya
    resolve: {
        // Konfigurasi resolusi modul
    },
});

