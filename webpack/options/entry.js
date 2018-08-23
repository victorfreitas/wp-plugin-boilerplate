const { script, style } = require('../paths')

module.exports = {
  entry: {
    front: [script('front'), style('front')],
    admin: [script('admin'), style('admin')],
  },
}
