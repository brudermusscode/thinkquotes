const path = require("path");

module.exports = {
  entry: "./app/assets/frontend/_entry.dev.js",
  output: {
    path: path.resolve(__dirname, "public/assets/javascript"),
    filename: "[name].bundle.js",
    publicPath: "/assets/javascript/",
  },
  module: {
    rules: [
      {
        test: /\.(j|t)s$/,
        exclude: [/[\\/]node_modules[\\/]/],
        loader: "builtin:swc-loader",
      },
      {
        test: /\.(sass|scss)$/,
        use: [
          "style-loader",
          "css-loader",
          {
            loader: "sass-loader",
            options: {
              api: "modern-compiler",
              sourceMap: true,
              implementation: require.resolve("sass-embedded"),
              quietDeps: true,
            },
          },
        ],
      },
    ],
  },
  devServer: {
    port: 8080,
    host: "0.0.0.0",
    allowedHosts: "all",
    static: "./public/assets/javascript",
    proxy: {
      "/": "http://thinkquotes-frontend-web:80",
    },
  },
  watchOptions: {
    ignored: /node_modules/,
    aggregateTimeout: 100,
    poll: 100,
  },
  mode: "development",
  devtool: "inline-source-map",
};
