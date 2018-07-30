const { script, style } = require('../paths')

module.exports = () => ({
  entry: {
    front: [
      `${script('front')}/index.js`,
      `${style('front')}/style.scss`
    ],
    admin: [
      `${script('admin')}/index.js`,
      `${style('admin')}/style.scss`
    ]
}
})
