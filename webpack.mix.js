let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.js('resources/admin/js/admin-scrut.js', 'admin/assets/js/')
  .sass('resources/admin/sass/admin-scrut.scss', 'admin/assets/css/');

mix.js('resources/public/js/scrut.js', 'public/assets/js/')
  .sass('resources/public/sass/scrut.scss', 'public/assets/css/');