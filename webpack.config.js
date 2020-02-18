const webpack = require('webpack');
const path = require('path');
const { argv } = require('yargs');
const CopyGlobsPlugin = require('copy-globs-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { default: ImageminPlugin } = require('imagemin-webpack-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const imageminMozjpeg = require('imagemin-mozjpeg');

const isProduction = !!((argv.env && argv.env.production) || argv.p);
const assetsFilenames = (isProduction) ? '[name]_[hash:8]' : '[name]';
let sitepath = path.resolve(__dirname, '../../../../..'); // /var/www/html/sitename
let pluginpath = path.resolve(__dirname, '..'); // /var/www/html/sitename/web/app/plugins/pluginname
pluginpath = pluginpath.substr(sitepath.length + 5); // /app/plugins/pluginname  

console.log("Mode : " + (isProduction ? 'Production' : 'Développement'));

let webpackConfig = {
  context: path.resolve(__dirname, './assets'),
  devtool: (isProduction ? undefined : '#source-map'),
  entry: {
    "main": [
      './scripts/main.jsx',
      './styles/main.scss'
    ]
  },
  output: {
    path: path.resolve(__dirname, "./dist"),
    publicPath: pluginpath,
    filename: `scripts/${assetsFilenames}.js`
  },
  stats: {
    hash: false,
    version: false,
    timings: false,
    children: false,
    //errors: false,
    //errorDetails: false,
    warnings: false,
    chunks: false,
    modules: false,
    reasons: false,
    source: false,
    publicPath: false,
  },
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.jsx?$/,
        include: [
          path.resolve(__dirname, "./scripts/"),
          path.resolve(__dirname, "../blocks/**/assets/scripts/")
        ],
        use: 'eslint-loader',
      },
      {
        test: /\.scss$/,
        use: [
          { loader: MiniCssExtractPlugin.loader, options: { sourceMap: !isProduction } },
          { loader: 'css-loader', options: { sourceMap: !isProduction } },
          {
            loader: 'postcss-loader',
            options: {
              config: { path: __dirname, ctx: { optimize: isProduction } },
              sourceMap: !isProduction
            }
          },
          { loader: 'cache-loader' },
          {
            loader: 'sass-loader', options: {
              sourceMap: !isProduction,
            }
          }
        ]
      },
      {
        test: /.(js|jsx)$/,
        exclude: /.s?css$/,
        use: [
          { loader: 'cache-loader' },
          {
            loader: "babel-loader",
            options: {
              presets: ['@babel/react', '@babel/env']
            }
          }
        ]
      },
      {
        test: /\.(png|jpe?g|gif|svg|ico)$/,
        use: [
          {
            loader: 'file-loader', options: {
              publicPath: "../",
              name: 'images/[name].[ext]',
            }
          }
        ]
      },
      {
        test: /\.(ttf|otf|eot|woff2?)$/,
        use: [
          {
            loader: 'file-loader', options: {
              publicPath: "../",
              name: 'fonts/[name].[ext]',
            }
          }
        ]
      },
    ]
  },
  resolve: {
    extensions: ['.js', '.jsx'],
  },
  plugins: [
    require("autoprefixer"),
    new CleanWebpackPlugin({ cleanStaleWebpackAssets: false }),
    new CopyGlobsPlugin({
      pattern: 'images/**/*',
      output: `[path]${assetsFilenames}.[ext]`,
      manifest: {},
    }),
    new MiniCssExtractPlugin({
      filename: `styles/${assetsFilenames}.css`,
      allChunk: true,
      disable: !!argv.watch,
    }),
    new webpack.LoaderOptionsPlugin({
      test: /\.s?css$/,
      options: {
        output: { path: path.resolve(__dirname, './dist/') },
        context: path.resolve(__dirname, './assets'),
      },
    }),
    new webpack.LoaderOptionsPlugin({
      test: /\.jsx?$/,
      options: {
        eslint: { failOnWarning: false, failOnError: true },
      },
    }),
    new StyleLintPlugin({
      failOnError: !argv.watch,
      syntax: 'scss',
    }),
    new ImageminPlugin({
      optipng: { optimizationLevel: 2 },
      gifsicle: { optimizationLevel: 3 },
      pngquant: { quality: '65-90', speed: 4 },
      svgo: {
        plugins: [
          { removeUnknownsAndDefaults: false },
          { cleanupIDs: false },
          { removeViewBox: false },
        ],
      },
      plugins: [imageminMozjpeg({ quality: 75 })],
      disable: !!argv.watch,
    })
  ]
}

function manifestFormater(key, value) {
  if (typeof value === 'string') {
    return value;
  }
  const manifest = value;
  Object.keys(manifest).forEach((src) => {
    const sourcePath = path.basename(path.dirname(src));
    const targetPath = path.basename(path.dirname(manifest[src]));
    if (sourcePath === targetPath) {
      return;
    }
    manifest[`${targetPath}/${src}`] = manifest[src];
    delete manifest[src];
  });
  return manifest;
};

if (isProduction) {
  const WebpackAssetsManifest = require('webpack-assets-manifest');

  webpackConfig.plugins.push(
    new WebpackAssetsManifest({
      output: 'assets.json',
      space: 2,
      writeToDisk: false,
      assets: {},
      replacer: manifestFormater
    })
  );
}

module.exports = webpackConfig;