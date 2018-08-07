module.exports = {
  test: /\.jsx?$/,
  enforce: 'pre',
  exclude: /node_modules/,
  use: {
    loader: 'eslint-loader'
  }
}
