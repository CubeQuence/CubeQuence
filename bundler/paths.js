const path = require('path')

module.exports = {
  // The base path of your source files, especially of your index.js
  SRC: path.resolve(__dirname, '..', 'resources'),

  // The path to put the generated bundle(s)
  DIST: path.resolve(__dirname, '..', 'public', 'assets'),

 // This is your public path.
  ASSETS: '/assets'
}
