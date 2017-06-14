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
  .js('resources/assets/js/quotas.js', 'js')
  .js('resources/assets/js/team.js', 'js')
  .extract(['vue', 'vue-router'],'js/vendor.js');

if (Config.production) {
    mix.version();
}




