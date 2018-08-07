const { join } = require('path')

const rootPath = join(__dirname, '..')
const assets = `${rootPath}/assets`

module.exports = {
  rootPath,
  assets,
  css: `${assets}/css`,
  dist: `${assets}/dist`,
  fonts: `${assets}/fonts`,
  images: `${assets}/images`,
  js: `${assets}/js`,
  scss: `${assets}/scss`,
  style(name) {
    return `${assets}/scss/${name}`
  },
  script(name) {
    return `${assets}/js/${name}/src`
  }
}
