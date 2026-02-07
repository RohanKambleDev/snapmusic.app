import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
	server: {
		host: '0.0.0.0',
		cors: true,
		hmr: {
			host: 'snapmusic.local',
		},
	},
	plugins: [
		laravel({
			input: [
				"resources/css/app.css",
				"resources/js/app.js",
				"resources/js/make-a-video.js",
				"resources/js/job-status.js",
			],
			refresh: true,
		}),
	],
});
