require("dotenv").config();

// ENV vars
const { APP_MODE } = process.env;

// Basic packages
const mix = require("laravel-mix");
const path = require("path");
const fs = require("fs");
const yaml = require("yaml");
const notifier = require("node-notifier");

mix.disableNotifications();

// Packages
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const CopyPlugin = require("copy-webpack-plugin");
const ImageminWebpWebpackPlugin = require("imagemin-webp-webpack-plugin");
const { VueLoaderPlugin } = require("vue-loader");

/**
 * Get config data
 *
 * @param config
 * @returns {any}
 */
function getConfig(config) {
  const pathToConfigs = path.resolve(__dirname, "configs");
  const configToString = fs.readFileSync(pathToConfigs + config, "utf8");

  return yaml.parse(configToString);
}

// configs/packages/asset.yaml -> config
const assetConfig = getConfig("/packages/asset.yaml").asset;

/**
 * @returns {*}
 * @param type
 */
function getEntryFiles(type) {
  return assetConfig.webpack.entryFiles[type];
}

/**
 * @returns {{}}
 */
function getWebpackAliases() {
  const webpackAliasesFromConfig = assetConfig.webpack.moduleAliases;
  const webpackAliases = {};

  for (const key in webpackAliasesFromConfig) {
    webpackAliases[`@${key}`] = path.join(
      __dirname,
      webpackAliasesFromConfig[key]
    );
  }

  return webpackAliases;
}

const assetsPath = assetConfig.paths.assets;
const distPath = assetConfig.paths.dist;

// Build
mix
  .js(assetsPath + getEntryFiles("js"), `${distPath}js`)
  .sass(assetsPath + getEntryFiles("sass"), `${distPath}css`)
  .options({
    processCssUrls: false,
    postCss: [
      require("postcss-preset-env"),
      require("autoprefixer")({
        cascade: false
      }),
      require("postcss-custom-properties"),
      require("postcss-sort-media-queries")
    ]
  })
  .alias(getWebpackAliases())
  .vue()
  .webpackConfig({
    mode: APP_MODE,
    resolve: {
      extensions: [".js", ".json", ".vue"]
    },
    plugins: [
      new MiniCssExtractPlugin({
        filename: `${distPath}css/app.css`
      }),
      new CopyPlugin({
        patterns: [{ from: `${assetsPath}images`, to: `${distPath}images` }]
      }),
      new ImageminWebpWebpackPlugin({
        config: [
          {
            test: /\.(jpe?g|png)/,
            options: {
              quality: 75
            }
          }
        ]
      }),
      new VueLoaderPlugin()
    ],
    optimization: {
      minimize: APP_MODE !== "development",
      minimizer: [
        new TerserPlugin({
          test: /\.js$/,
          extractComments: assetConfig.webpack.extractJsComments
        }),
        new CssMinimizerPlugin({
          test: /.(css|scss|sass)/,
          exclude: /(node_modules|bower_components)/
        })
      ]
    }
  })
  .then((stats) => {
    const jsonStats = stats.toJson();
    let message = "Successful build";

    if (jsonStats.errors.length > 0) {
      message = `Error: ${jsonStats.errors[0].message}`;
    } else if (jsonStats.warnings.length > 0) {
      message = `Warning: ${jsonStats.warnings[0].message}`;
    }

    notifier.notify({
      title: "Codememory",
      message,
      icon: path.join(__dirname, "public/assets/images/codememory_icon.png"),
      sound: true,
      wait: true
    });
  });
