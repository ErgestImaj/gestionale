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
    .copy('resources/js/actions/','public/js')
    .copy('resources/js/datatables/','public/js')
    .copy('resources/js/summernote/config.js','public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('resources/sass/style.css','public/css/')
   .copy('resources/sass/addons.css','public/css/')
   .copy('resources/sass/summernote/summernote-bs4.css','public/css/')
   .copy('resources/fonts','public/fonts')
   .copy('resources/images/','public/images')
   .copy('resources/sass/summernote/fonts','public/css/font');
