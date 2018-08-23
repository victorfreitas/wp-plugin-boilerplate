const CleanWebpackPlugin = require('clean-webpack-plugin')

const { rootPath } = require('../paths')

module.exports = new CleanWebpackPlugin(['dist'], {
  root: rootPath,
  verbose: true,
})
