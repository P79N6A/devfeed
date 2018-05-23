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

const cssCachePath = 'public/.temp/';

mix.styles([
  'node_modules/bootstrap/dist/css/bootstrap.min.css',
  'node_modules/bootstrap/dist/css/bootstrap-theme.min.css',
], 'public/css/bootstrap.css')
  .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
  .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js');

mix.options({
  extractVueStyles: cssCachePath+'vue.css'
});

mix.sass('resources/assets/sass/backend.scss', cssCachePath)
  .js('resources/assets/js/quotas.js', 'public/js/')
  .js('resources/assets/js/team.js', 'public/js/')
  .js('resources/assets/js/source.js', 'public/js/')
  .js('resources/assets/js/app/front.js', 'public/js/')
  .extract(['babel-polyfill','axios', 'vue', 'vue-router'], 'public/js/vendor.js');

mix.styles([cssCachePath+'backend.css', cssCachePath+'vue.css'], 'public/css/backend.css');

if (mix.inProduction()) {
    mix.version([
        'public/js/quotas.js',
        'public/js/team.js',
        'public/js/source.js',
        'public/js/front.js',
        'public/css/backend.css',
    ]);
}


