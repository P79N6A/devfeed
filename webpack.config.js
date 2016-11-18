/**
 * Created by kaireewu on 2016/11/18.
 */
const path = require('path')
const webpack = require('webpack')
const nodeModules = path.resolve(__dirname, 'node_modules')
const pathToVue = path.resolve(nodeModules, 'vue/dist/vue.js')
const pathToResource = path.resolve(nodeModules, 'vue-resource/dist/vue-resource.js')

module.exports = {
  entry: {
    quotas: './resources/assets/js/quotas.js',
    vendors: ['vue', 'vue-resource']
  },
  resolve: {
    alias: {
      'vue': pathToVue,
      'vue-resource': pathToResource
    }
  },
  output: {
    path: path.resolve(__dirname, 'public/js'),
    filename: '[name].js',
    chunkFilename: '[name].min.js'
  },
  plugins: [
    new webpack.optimize.CommonsChunkPlugin({name: 'vendors', filename: 'vue.min.js'}),
    new webpack.optimize.UglifyJsPlugin()
  ]
}
