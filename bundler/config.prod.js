const merge = require('webpack-merge')

module.exports = merge(require('./config.base.js'), {
  mode: 'production'

  // We'll place webpack configuration for production environment here
})

// TODO: run imagemin,webpack-manifest-plugin
