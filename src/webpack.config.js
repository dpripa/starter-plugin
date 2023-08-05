const dotenv = require( 'dotenv' ).config();
const entry = require( './entry' );
const path = require( 'path' );
const Webpack = require( 'webpack' );
const BrowserSync = require( 'browser-sync' );
const {CleanWebpackPlugin} = require( 'clean-webpack-plugin' );
const Terser = require( 'terser-webpack-plugin' );
const MiniCssExtract = require( 'mini-css-extract-plugin' );
const FixStyleOnlyEntries = require( 'webpack-fix-style-only-entries' );
const Autoprefixer = require( 'autoprefixer' );
const OptimizeCssAssets = require( 'optimize-css-assets-webpack-plugin' );
const StyleLint = require( 'stylelint-webpack-plugin' );
const Copy = require( 'copy-webpack-plugin' );
const {default: ImageminPlugin} = require( 'imagemin-webpack-plugin' );
const ImageminMozjpeg = require( 'imagemin-mozjpeg' );

const paths = {
	asset: path.resolve( __dirname, '../asset' ),
	source: path.resolve( __dirname, '.' )
};
const dirs = {
	script: 'script',
	style: 'style',
	image: 'image',
	font: 'font'
};
const assetPrefix = '.min';
const mode = process.env.NODE_ENV;
const isDev = 'development' === mode;

function stats() {
	const stats = {
		all: false,
		errors: true,
		errorDetails: true,
		performance: true,
		timings: true
	};

	if ( ! isDev ) {
		stats.assets = true;
		stats.cachedAssets = true;
		stats.publicPath = true;
	}

	return stats;
}

function optimization() {
	const optimization = {};

	if ( ! isDev ) {
		optimization.minimizer = [
			new OptimizeCssAssets(
				{
					cssProcessorPluginOptions: {
						preset: [
							'default',
							{
								discardComments: {
									removeAll: true
								}
							}
						]
					}
				}
			),
			new Terser(
				{
					terserOptions: {
						output: {
							comments: false
						}
					},
					extractComments: false
				}
			)
		];
	}

	return optimization;
}

if ( isDev ) {
	BrowserSync(
		{
			files: [
				`${paths.asset}/${dirs.script}/*.js`,
				`${paths.asset}/${dirs.style}/*.css`,
				path.resolve( __dirname, '../**/*.php' )
			],
			port: process.env.BROWSERSYNC_PORT,
			proxy: {
				target: process.env.BROWSERSYNC_PROXY,
				proxyReq: [
					function( proxyReq ) {
						proxyReq.setHeader( 'X-Webpack-Dev-Server', 'yes' );
						proxyReq.setHeader( 'X-Webpack-Dev-Server-Base-URL', process.env.BROWSERSYNC_PROXY );
					}
				]
			},
			open: false,
			ui: false,
			ghostMode: false
		}
	);
}

module.exports = {
	mode: mode,
	context: paths.source,
	entry: entry,
	output: {
		filename: `${dirs.script}/[name]${assetPrefix}.js`,
		path: paths.asset
	},
	devtool: isDev ? '#cheap-module-source-map' : '',
	stats: stats(),
	optimization: optimization(),
	module: {
		rules: [
			{
				enforce: 'pre',
				test: /\.js$/,
				exclude: '/node_modules/',
				use: [
					{
						loader: 'eslint-loader',
						options: {
							fix: ! isDev
						}
					}
				]
			},
			{
				test: /\.js$/,
				exclude: '/node_modules/',
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: [
								'@babel/preset-env'
							]
						}
					}
				]
			},
			{
				test: /\.scss$/,
				use: [
					{
						loader: MiniCssExtract.loader,
						options: {
							reloadAll: true
						}
					},
					{
						loader: 'css-loader',
						options: {
							url: false,
							sourceMap: isDev
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							plugins: [
								Autoprefixer()
							],
							sourceMap: isDev
						}
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: isDev
						}
					}
				]
			},
			{
				test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							publicPath: '../',
							name: '[path][name].[ext]'
						}
					}
				]
			},
			{
				test: /\.(ttf|otf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
				include: /node_modules/,
				use: [
					{
						loader: 'file-loader',
						options: {
							outputPath: 'vendor/',
							name: '[name].[ext]'
						}
					}
				]
			}
		]
	},
	externals: {
		jquery: 'jQuery'
	},
	plugins: [
		new CleanWebpackPlugin(
			{
				cleanStaleWebpackAssets: false
			}
		),
		new Webpack.ProvidePlugin(
			{
				$: 'jquery',
				jQuery: 'jquery',
				'window.jQuery': 'jquery'
			}
		),
		new StyleLint(
			{
				syntax: 'scss'
			}
		),
		new MiniCssExtract(
			{
				filename: `${dirs.style}/[name]${assetPrefix}.css`
			}
		),
		new FixStyleOnlyEntries(
			{
				silent: true
			}
		),
		new Copy(
			[
				{
					from: dirs.image,
					to: `${paths.asset}/${dirs.image}`
				},
				{
					from: dirs.font,
					to: `${paths.asset}/${dirs.font}`
				}
			],
			{
				ignore: [ '.gitkeep', '.DS_Store', 'Thumbs.db', 'ehthumbs.db' ]
			}
		),
		new ImageminPlugin(
			{
				optipng: {
					optimizationLevel: 2
				},
				gifsicle: {
					optimizationLevel: 3
				},
				pngquant: {
					quality: '65-90',
					speed: 4
				},
				svgo: {
					plugins: [
						{
							removeUnknownsAndDefaults: false
						},
						{
							cleanupIDs: false
						},
						{
							removeViewBox: false
						}
					]
				},
				plugins: [
					ImageminMozjpeg(
						{
							quality: 75
						}
					)
				],
				disable: isDev
			}
		)
	]
};
