const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  context: path.resolve(__dirname, '../src'),
  entry: {
    app: './js/index.js'
  },
  output: {
    path: path.resolve(__dirname, '../dist')
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "../style.css",
    })
  ],
  externals: {
    // require("jquery") is external and available
    // on the global var jQuery
    "jquery": "jQuery"
  },
  module: {
    rules: [
      {
        test: /\.(css|scss)$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'postcss-loader' },
          {
            /* for ~slick-carousel/slick/slick-theme.scss */
            loader: 'resolve-url-loader' },
          {
            /* for resolve-url-loader:
                source maps must be enabled on any preceding loader */
            loader: 'sass-loader?sourceMap' }
        ]
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: 'babel-loader'
      },
      { /* for ~slick-carousel/slick/slick-theme.scss */
        test: /\.(eot|woff|woff2|ttf|svg|png|jpg|gif)$/,
        loader: 'url-loader?limit=30000&name=[name]-[hash].[ext]'
      }
    ]
  }
}
