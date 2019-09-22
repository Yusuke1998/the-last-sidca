const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles('public/assets/css/oneui.min.css','public/css/all.css')
   .scripts([
    'public/assets/js/core/bootstrap.bundle.min.js',
    'public/assets/js/core/simplebar.min.js',
    'public/assets/js/core/jquery-scrollLock.min.js',
    'public/assets/js/core/jquery.appear.min.js',
    'public/assets/js/core/js.cookie.min.js',
    'public/assets/js/oneui.app.min.js',
    'public/assets/js/pages/be_pages_dashboard.min.js'],'public/js/all.js');
