let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js/custom')
  .js('resources/assets/js/login.js', 'public/js/custom')
  .js('resources/assets/js/nilai.js', 'public/js/custom')
  .sass('resources/assets/sass/login.scss', 'public/css')
  .sass('resources/assets/sass/news.scss', 'public/css')
  .sass('resources/assets/sass/nilai.scss', 'public/css')
  .sass('resources/assets/sass/mahasiswa.scss', 'public/css')
  .sass('resources/assets/sass/app.scss', 'public/css');