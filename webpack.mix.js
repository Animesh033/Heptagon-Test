const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/heptagon/sass/app.scss', 'public/heptagon/css')
    .styles([
        'resources/heptagon/css/app.css',
    ], 'public/heptagon/css/app.css')
    .scripts([
     'resources/heptagon/js/app.js',
     ], 'public/heptagon/js/app.js')
    .sourceMaps();
