const mix = require('laravel-mix')
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [require('postcss-import'), require('postcss-nesting'), require('tailwindcss'), require('autoprefixer')])
    .webpackConfig({
        output: { chunkFilename: 'js/[name].js?id=[chunkhash]', publicPath: '/' },
        resolve: {
            extensions: ['.js', '.svelte'],
            mainFields: ['svelte', 'browser', 'module', 'main'],
            alias: {
                '@': path.resolve('resources/js'),
            },
        },
        module: {
            rules: [
                {
                    test: /\.(svelte)$/,
                    use: {
                        loader: 'svelte-loader',
                        options: {
                            emitCss: true,
                            hotReload: true,
                        },
                    },
                },
            ],
        },
    })

if (mix.inProduction()) {
    mix.version()
}
