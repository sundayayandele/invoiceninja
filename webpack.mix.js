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


mix.copyDirectory('node_modules/@coreui/coreui/dist/css/coreui.min.css', 'public/vendors/css/coreui.min.css');
mix.copyDirectory('node_modules/@coreui/icons/css/coreui-icons.min.css', 'public/vendors/css/coreui-icons.min.css');
mix.copyDirectory('node_modules/@coreui/coreui/dist/css/bootstrap.min.css', 'public/vendors/css/bootstrap.min.css');
mix.copyDirectory('node_modules/font-awesome/css/font-awesome.min.css', 'public/vendors/css/font-awesome.min.css');
mix.copyDirectory('node_modules/@coreui/coreui/dist/js/coreui.min.js', 'public/vendors/js/coreui.min.js');
mix.copyDirectory('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/vendors/js/bootstrap.min.js');
mix.copyDirectory('node_modules/jquery/dist/jquery.min.js', 'public/vendors/js/jquery.min.js');
mix.copyDirectory('node_modules/popper.js/dist/popper.min.js', 'public/vendors/js/popper.min.js');
mix.copyDirectory('node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js', 'public/vendors/js/perfect-scrollbar.min.js');

mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts');

mix.version();