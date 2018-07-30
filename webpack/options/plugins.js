const plugins = require('../plugins')

module.exports = prod => ({
  plugins: plugins(prod)
})
