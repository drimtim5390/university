const {defineConfig} = require('@vue/cli-service')

module.exports = defineConfig({
  runtimeCompiler: true,
  transpileDependencies: true,
  pages: {
    index: {
      entry: 'resources/js/app.js',
      template: 'resources/js/index.html'
    }
  },
  devServer: {
    proxy: {
      '^/api': {
        target: 'http://localhost:8080',
        changeOrigin: true
      },
    }
  }
})
