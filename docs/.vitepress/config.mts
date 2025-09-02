import { defineConfig } from 'vitepress'
import pkg from '../package.json'
import llmstxt, { copyOrDownloadAsMarkdownButtons } from 'vitepress-plugin-llms'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel Image Transform URL",
    description: "Easy, URL-based image transformations for Laravel inspired by Cloudflare Images.",
    srcDir: './pages',
    cleanUrls: true,
    markdown: {
        theme: {
            light: 'github-light',
            dark: 'github-dark'
        },
        config(md) {
            md.use(copyOrDownloadAsMarkdownButtons)
        }
    },
    vite: {
        plugins: [llmstxt()]
    },
    themeConfig: {
        // https://vitepress.dev/reference/default-theme-config
        nav: [
            { text: 'Home', link: '/' },
            {
                text: pkg.version,
                items: [
                    {
                        text: 'Changelog',
                        link: 'https://github.com/ace-of-aces/laravel-image-transform-url/blob/main/CHANGELOG.md'
                    },
                    {
                        text: 'Contributing',
                        link: 'https://github.com/ace-of-aces/laravel-image-transform-url/blob/main/CONTRIBUTING.md'
                    }
                ]
            }
        ],

        sidebar: [
            {
                text: 'Basics',
                items: [
                    { text: 'Installation', link: '/installation' },
                    { text: 'Setup', link: '/setup' },
                    { text: 'Getting Started', link: '/getting-started' },
                ]
            },
            {
                text: 'Options',
                items: [
                    { text: 'Configuring Options', link: '/configuring-options' },
                    { text: 'Available Options', link: '/available-options' },
                ]
            },
            {
                text: 'Advanced',
                items: [
                    { text: 'Signed URLs', link: '/signed-urls' },
                    { text: 'Image Caching', link: '/image-caching' },
                    { text: 'Rate Limiting', link: '/rate-limiting' },
                    { text: 'S3 Usage', link: '/s3-usage' },
                    { text: 'CDN Usage', link: '/cdn-usage' },
                    { text: 'Error Handling', link: '/error-handling' },
                ]
            }
        ],

        socialLinks: [
            { icon: 'github', link: 'https://github.com/ace-of-aces/laravel-image-transform-url' },
        ],

        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2025-present Julian Schramm'
        },

        search: {
            provider: 'local',
        }
    }
})
