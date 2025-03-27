const path = require("path");

module.exports = {
  mode: "production",
  entry: "./app/assets/frontend/_entry.prod.js",
  output: {
    path: path.resolve(__dirname, "public/assets/javascript"),
    filename: "[name].production.bundle.js",
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
              implementation: require.resolve("sass-embedded"),
            },
          },
        ],
      },
    ],
  },
};
