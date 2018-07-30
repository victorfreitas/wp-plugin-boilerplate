const globImporter = require('node-sass-glob-importer')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

module.exports = prod => ({
  test: /\.s?css$/,
  use: [
    {
      loader: MiniCssExtractPlugin.loader
    },
    {
      loader: 'css-loader',
      options: { sourceMap: !prod }
    },
    {
      loader: 'sass-loader',
      options: {
        sourceMap: !prod,
        importer: globImporter()
      }
    }
  ]
})
