import { defineConfig } from 'vite'
import path from 'path'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  build: {
	outDir: 'dist',
	emptyOutDir: true,
		rollupOptions: {
			input: path.resolve(__dirname, 'src/main.jsx'), // Ensure correct entry file
			output: {
				entryFileNames: '[name].js',
				assetFileNames: '[name].[ext]',
			},
		}
	},
	resolve: {
        alias: {
            "@pulse/ui": path.resolve(__dirname, "../packages/ui/src"), // Allow UI package imports
        },
    },
})
