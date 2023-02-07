const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  pages: {
      index: {
          entry: 'resources/js/app.js',
          template: 'resources/js/index.html'
      }
  }
})
