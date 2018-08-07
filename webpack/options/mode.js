const isDev = require('../is-dev')

module.exports = {
  mode: isDev ? 'development' : 'production'
}
