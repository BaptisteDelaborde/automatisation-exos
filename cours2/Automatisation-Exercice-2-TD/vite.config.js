import { defineConfig } from 'vite'
import path from 'path'

export default defineConfig({
    root: './assets',
    base: '/build/',
    server: {
        host: '0.0.0.0',
        port: 3000,
    },
    build: {
        outDir: '../public/build',
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'assets/script.js'),
            },
        },
    },
})
