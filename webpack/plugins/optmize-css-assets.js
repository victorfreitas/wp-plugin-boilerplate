const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const cssnano = require('cssnano')

module.exports = prod => (
  prod && new OptimizeCSSAssetsPlugin({
    cssProcessor: cssnano,
    cssProcessorOptions: {
      options: {
        discardComments: {
          removeAll: true,
        },
        safe: true,
      },
    },
    canPrint: false,
  })
)
