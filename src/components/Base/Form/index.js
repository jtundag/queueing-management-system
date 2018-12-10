const files = require.context('.', false, /\.vue$/)
const fields = {}

files.keys().forEach(key => {
    if (key === './index.js') return
    fields[key.replace(/(\.\/|\.vue)/g, '')] = files(key)
})

export default fields