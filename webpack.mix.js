let mix = require('laravel-mix')

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

mix.combine([
  'node_modules/bootstrap/dist/css/bootstrap.min.css',
  'node_modules/bootstrap/dist/css/bootstrap-theme.min.css',
], 'public/css/bootstrap.css')
  .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
  .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')

mix.options({
  extractVueStyles: true
})

mix.sass('resources/assets/sass/vue.scss', 'public/css/')
  .sass('resources/assets/sass/backend.scss', 'public/css')
  .js('resources/assets/js/quotas.js', 'public/js/')
  .js('resources/assets/js/team.js', 'public/js/')
  .extract(['axios', 'vue', 'vue-router'], 'public/js/vendor.js')
  .then(() => {
    mix.combine(['public/css/backend.css', 'public/css/vue.css'], 'public/css/backend.css')
  }).version()

