const { scss, assets } = require('../paths')

module.exports = () => ({
  resolve: {
    extensions: ['.js', '.ts', '.jsx', '.tsx', '.json', '.scss', '.css'],
    alias: {
      '~': scss,
      assets
    }
  }
})
