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

mix.js([
    'resources/assets/js/app.js',
    // 'public/mooimarkt/assets/jquery/jquery.min.js',
    // 'public/mooimarkt/assets/slick/slick.min.js',
    // 'public/mooimarkt/assets/fancybox/jquery.fancybox.min.js',
    // // 'public/mooimarkt/assets/dropzone/dropzone.min.js',
    // 'public/mooimarkt/assets/select2/select2.min.js',
    // 'public/js/fileupload/vendor/jquery.ui.widget.js',
    // 'public/js/fileupload/jquery.iframe-transport.js',
    // // 'public/js/fileupload/jquery.fileupload.js',
    // 'public/mooimarkt/js/chat.js',
    // 'public/mooimarkt/js/common.js',
    // 'public/mooimarkt/js/common_anton.js',
    // 'public/mooimarkt/js/common_artur.js',
    // 'public/mooimarkt/js/v_script.js',
], 'public/js/app.js')
   .sass('resources/assets/sass/app.scss', 'public/css');
