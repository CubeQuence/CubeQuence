const path = require('path')
const glob = require("glob")
const { ProvidePlugin } = require('webpack');
const ManifestPlugin = require('webpack-manifest-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const SRC =path.resolve(__dirname, '..', 'resources');

module.exports = {  
  entry: {
    index: path.resolve(SRC, 'js', 'index.js'),
    css: glob.sync(`${SRC}/css/*.css`),
    // pages: glob.sync(`${SRC}/js/pages/*.js`)
  },
  "module": {
    "rules": [
      {
        "test": /\.css$/,
        "use": [
          "style-loader",
          "css-loader"
        ]
      }
    ]
  },
  resolve: {
    extensions: ['.js'],
    alias: {
      'utils': path.resolve(SRC, 'js', 'utilities.js')
    }
  },
  plugins: [
    new ManifestPlugin({
      fileName: path.resolve(__dirname, '..', 'public', 'asset-manifest.json')
    }),
    new CleanWebpackPlugin(),
    new ProvidePlugin({
      'utils': 'utils'
    })
  ],
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin({
      cache: true,
      parallel: true
    })],
  },
  output: {
    filename: '[name].[chunkhash].js',
    path: path.resolve(__dirname, '..', 'public', 'assets'),
    publicPath: '/assets/'
  }
}

// TODO: imagemin
