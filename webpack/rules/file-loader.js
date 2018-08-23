module.exports = {
  test: /\.(png|gif|jpe?g|svg|woff2?|ttf|eot)$/,
  rules: [
    {
      loader: 'file-loader',
      options: {
        name: '[path][name].[ext]',
        outputPath: file => file.replace('assets', '..'),
      },
    },
  ],
}
