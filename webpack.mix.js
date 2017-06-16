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
mix = mix.webpackConfig({
  resolve: {
    alias: {
      //'vue$': 'vue/dist/vue.runtime.esm.js',
      'vue-router$': 'vue-router/dist/vue-router.esm.js'
    }
  }
});

mix = mix.sass('resources/assets/sass/backend.scss', 'css')
  .styles([
    'node_modules/bootstrap/dist/css/bootstrap.min.css',
    'node_modules/bootstrap/dist/css/bootstrap-theme.min.css',
  ], 'css/bootstrap.css')
  .js('resources/assets/js/quotas.js', 'js')
  .js('resources/assets/js/team.js', 'js')
  .extract(['axios','vue', 'vue-router'],'js/vendor.js')
  .copy('node_modules/jquery/dist/jquery.min.js', 'js/jquery.min.js')
  .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'js/bootstrap.min.js');

if (Config.production) {
    mix.version();
}




