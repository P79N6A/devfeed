/**
 * Created by kaireewu on 2016/11/18.
 */
const path = require('path')
const webpack = require('webpack')
const nodeModules = path.resolve(__dirname, 'node_modules')
const pathToVue = path.resolve(nodeModules, 'vue/dist/vue.common.js')

module.exports = {
  entry: {
    quotas: './resources/assets/js/quotas.js',
    vendors: ['vue', 'vue-resource']
  },
  resolve: {
    alias: {
      'vue$': pathToVue
    }
  },
  output: {
    path: path.resolve(__dirname, 'public/js'),
    filename: '[name].js',
    chunkFilename: '[name].min.js'
  },
  plugins: [
    new webpack.optimize.CommonsChunkPlugin({name: 'vendors', filename: 'vue.min.js'}),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    })
  ]
}
