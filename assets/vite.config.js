import { defineConfig } from 'vite';
import stylelint from 'vite-plugin-stylelint';
import path from 'path';

export default defineConfig({
	build: {
		outDir: 'dist',
		emptyOutDir: true,
		css: {
			postcss: path.resolve(__dirname, '../postcss.config.js'),
		},
		rollupOptions: {
			external: ['react', 'react-dom'],
			input: {
				pulse: 'src/js/pulse.js',
				widget: 'src/js/widget.jsx',
				admin: 'src/css/admin.css',
			},
			output: {
				globals: {
					react: 'React',
					'react-dom': 'ReactDOM',
				},
				entryFileNames: '[name].js',
				assetFileNames: '[name].[ext]',
			},
		},
	},
	plugins: [stylelint()],
	minify: 'esbuild',
});
