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
   .styles([
        'public/assets/css/oneui.css',
        'public/assets/css/alertify.min.css',
        'public/assets/css/default.min.css',
        'public/assets/css/custom.css'
    ],'public/css/all.css')
   .scripts([
        'public/assets/js/core/bootstrap.bundle.min.js',
        'public/assets/js/core/simplebar.min.js',
        'public/assets/js/core/jquery-scrollLock.min.js',
        'public/assets/js/core/jquery.appear.min.js',
        'public/assets/js/core/js.cookie.min.js',
        'public/assets/js/oneui.app.min.js',
        'public/assets/js/pages/be_pages_dashboard.min.js'
   	],'public/js/all.js');

mix.browserSync('http://127.0.0.1:8000')