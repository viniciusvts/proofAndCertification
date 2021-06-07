const mix = require('laravel-mix');

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

mix.js('resources/js/jquery-1.11.0.min', 'public/js/')
    .js('resources/js/dotest', 'public/js/')
    .js('resources/js/functions', 'public/js/')
    .js('resources/js/clock-countdown', 'public/js/')
    .js('resources/js/testescript', 'public/js/');
mix.sass('resources/sass/style.scss', 'public/css/style.css')
    .sass('resources/sass/clock-countdown.scss', 'public/css/clock-countdown.css')
    .options({
       processCssUrls: false
    });