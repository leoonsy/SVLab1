module.exports = {
    css: {
      loaderOptions: {
        sass: {
          prependData: `
            @import "@/styles/_variables.scss";
          `
        }
      }
    },
    configureWebpack: {
      devtool: 'source-map'
    }
  };