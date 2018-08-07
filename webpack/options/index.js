module.exports = () => {
  const list = require('../autoload')(__dirname)
  let options = {}

  list.forEach(opt => {
    options = Object.assign({}, options, opt)
  })

  return options
}
