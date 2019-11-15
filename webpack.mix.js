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
   .sass('resources/sass/app.scss', 'public/css');

mix.styles([
   'public/pagina/css/bootstrap.css',
   'public/pagina/css/theme.css',
   'public/pagina/css/skins/skin-default.css',
   'public/pagina/css/plugins.css'
   ], 'public/css/pagina-css.css')
   .scripts([
   'public/pagina/js/jquery.min.js',
   'public/pagina/js/plugins/modernizr.js',
   'public/pagina/js/plugins/jquery.easing.js',
   'public/pagina/js/plugins/jquery-ui.min.js',
   'public/pagina/js/plugins/jquery.parallax.js',
   'public/pagina/js/plugins/bootstrap.bundle.min.js',
   'public/pagina/js/plugins/jquery.cookie.js',
   'public/pagina/js/plugins/owl.carousel.min.js',
   'public/pagina/js/plugins/slick.min.js',
   'public/pagina/js/plugins/jquery.countdown.min.js',
   'public/pagina/js/plugins/isotope.pkgd.min.js',
   'public/pagina/js/plugins/jquery.magnific-popup.min.js',
   'public/pagina/js/plugins/instafeed.min.js',
   'public/pagina/js/plugins/sticky-sidebar.js',
   'public/pagina/js/theme.js',
   'public/pagina/js/jquery.rut.js'
   ], 'public/js/pagina-js.js').version();

mix.styles([
   'public/intranet/css/pages/login-register-lock.css',
   'public/intranet/node_modules/morrisjs/morris.css',
   'public/intranet/css/style.min.css',
   'public/intranet/css/pages/dashboard1.css',
   'public/intranet/css/pages/floating-label.css'
], 'public/css/admin.css')
.scripts([
   'public/intranet/node_modules/jquery/jquery-3.2.1.min.js',
   'public/intranet/node_modules/popper/popper.min.js',
   'public/intranet/js/perfect-scrollbar.jquery.min.js',
   'public/intranet/js/waves.js',
   'public/intranet/js/sidebarmenu.js',
   'public/intranet/js/custom.js',
   'public/intranet/node_modules/jquery-sparkline/jquery.sparkline.min.js',
   'public/intranet/node_modules/raphael/raphael-min.js',
   'public/intranet/node_modules/morrisjs/morris.min.js',
   'public/intranet/js/dashboard1.js'
], 'public/js/admin.js').version();
   
         