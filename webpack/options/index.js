module.exports = prod => {
  const list = require('../autoload')(__dirname, prod)
  let options = {}

  list.forEach(opt => {
    options = Object.assign({}, options, opt)
  })

  return options
}
