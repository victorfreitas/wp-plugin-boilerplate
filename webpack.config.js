const options = require('./webpack/options')

module.exports = (_, argv) => (
  options(argv.production)
)
