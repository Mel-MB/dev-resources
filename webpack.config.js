const path = require('path');

module.exports = {
	mode: 'development',

	entry: [path.resolve('./app/source/js/app.js'),
          path.resolve('./app/source/styles/style.scss')
        ],
	output: {
		path: path.resolve(__dirname, 'public'),
		filename: 'js/main.js',
	},
      
  module: {
    rules: [
        { 
          test: /\.scss$/,
          use: [
            {
              loader: "file-loader",
              options: {
                  name: "css/[name].css",
              },
            },
            'extract-loader',
            {
              loader: 'css-loader',
              options: {
                sourceMap: true,
                url: false
              }
            },
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true,
              }
            },
            {
              loader: 'sass-resources-loader',
              options: {
                resources: ['./app/source/styles/vars.scss']
              },
            }
          ],
        },
    ],
  }, 
  devtool: 'source-map',
}