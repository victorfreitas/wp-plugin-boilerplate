const rules = require('../rules')

module.exports = prod => ({
  module: {
    rules: rules(prod)
  }
})
