const path = require('path');

module.exports = {
	entry: {
		bundle: './visual-builder/src/index.js',
	},
	externals: {
		underscore: '_',
		react: 'React',
		'react-dom': 'ReactDOM',
		jquery: 'jQuery',
	},
	module: {
		rules: [
			{
				test: /\.jsx?$/,
				exclude: /node_modules/,
				use: [
					{
						loader: 'thread-loader',
						options: {
							workers: -1,
						},
					},
					{
						loader: 'babel-loader',
						options: {
							compact: false,
							presets: [
								[
									'@babel/preset-env',
									{
										modules: false,
										targets: '> 5%',
									},
								],
								'@babel/preset-react',
							],
							cacheDirectory: false,
						},
					},
				],
			},
		],
	},
	resolve: {
		extensions: ['.js', '.jsx'],
	},
	output: {
		filename: 'dpcm-visual-builder.js',
		path: path.resolve(__dirname, 'assets/js'),
	},
	devtool: process.env.NODE_ENV === 'development' ? 'source-map' : false,
	mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
};
