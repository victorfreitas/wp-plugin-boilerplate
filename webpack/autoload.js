const fs = require('fs')
const path = require('path')

class Autoload {
  constructor(root) {
    this.root = path.join(root)
    this.noIndex = this.noIndex.bind(this)
    this.parse = this.parse.bind(this)

    this.init()
  }

  init() {
    this.setFiles()
    this.filterFiles()
    this.processFiles()
  }

  setFiles() {
    this.files = fs.readdirSync(this.root)
  }

  filterFiles() {
    this.files = this.files.filter(this.noIndex)
  }

  noIndex(file) {
    return !/^index\.(js|php|html?)$/.test(file)
  }

  processFiles() {
    this.files = this.files.map(this.parse)
  }

  parse(file) {
    return require(`${this.root}/${file}`)
  }

  toArray() {
    return this.files.filter(v => !!v)
  }
}

module.exports = root => new Autoload(root).toArray()
