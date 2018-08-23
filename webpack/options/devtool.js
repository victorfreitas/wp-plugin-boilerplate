const isDev = require('../is-dev')

module.exports = {
  devtool: isDev ? 'source-map' : false,
}
