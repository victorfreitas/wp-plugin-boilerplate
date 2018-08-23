const autoload = require('../autoload')

module.exports = () => {
  const list = autoload(__dirname)
  let options = {}

  list.forEach((opt) => {
    options = Object.assign(options, opt)
  })

  return options
}
