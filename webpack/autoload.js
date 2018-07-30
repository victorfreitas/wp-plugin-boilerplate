const fs = require('fs')
const path = require('path')

class Autoload {
  constructor(root, prod) {
    this.root = root
    this.prod = prod
    this.noIndex = this.noIndex.bind(this)
    this.parse = this.parse.bind(this)

    this.init()
  }

  init() {
    this.setRoot()
    this.setFiles()
    this.filterFiles()
    this.processFiles()
  }

  setRoot() {
    this.root = path.join(this.root)
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
    const fileData = require(`${this.root}/${file}`)
    return fileData(this.prod)
  }

  toArray() {
    return this.files.filter(v => !!v)
  }
}

module.exports = (root, prod) => {
  const autoload = new Autoload(root, prod)

  return autoload.toArray()
}
