const globImporter = require('node-sass-glob-importer')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const isDev = require('../is-dev')

module.exports = {
  test: /\.s?css$/,
  use: [
    {
      loader: MiniCssExtractPlugin.loader,
    },
    {
      loader: 'css-loader',
      options: {
        sourceMap: isDev,
      },
    },
    {
      loader: 'sass-loader',
      options: {
        sourceMap: isDev,
        importer: globImporter(),
      },
    },
  ],
}
