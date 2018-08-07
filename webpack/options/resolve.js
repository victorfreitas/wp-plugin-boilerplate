const { scss, assets } = require('../paths')

module.exports = {
  resolve: {
    extensions: ['.js', '.jsx', '.css', '.scss', '.json'],
    alias: {
      '~': scss,
      assets
    }
  }
}
