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
    .copy('resources/js/actions/actions.js','public/js/actions.js')
    .copy('resources/js/datatables/admin.js','public/js/admin.js')
    .copy('resources/js/datatables/segreteria.js','public/js/segreteria.js')
    .copy('resources/js/datatables/course.js','public/js/course.js')
    .copy('resources/js/datatables/search.js','public/js/search.js')
    .copy('resources/js/dashboard/dashboard.js','public/js/dashboard.js')
    .copy('resources/js/summernote/config.js','public/js/config.js')
   .sass('resources/sass/app.scss', 'public/css')
   .copy('resources/sass/style.css','public/css/style.css')
   .copy('resources/sass/addons.css','public/css/addons.css')
   .copy('resources/sass/summernote/summernote-bs4.css','public/css/summernote-bs4.css')
   .copy('resources/fonts','public/fonts')
   .copy('resources/images/','public/images')
   .copy('resources/sass/summernote/fonts','public/css/font');
