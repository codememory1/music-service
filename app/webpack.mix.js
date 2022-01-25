require("dotenv").config();

// ENV vars
const {APP_ENV} = process.env;

// Basic packages
const mix = require("laravel-mix");
const path = require("path");
const notifier = require("node-notifier");

mix.disableNotifications();

// Packages
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const {VueLoaderPlugin} = require("vue-loader");

/**
 * @param file
 * @returns {string}
 */
function compileAssetsPath(file) {
    return path.resolve(__dirname, "assets/") + `/${file}`;
}

/**
 * @param file
 * @returns {string}
 */
function compileDistPath(file) {
    return path.resolve(__dirname, "public/") + `/${file}`;
}

// Build
mix
    .js(compileAssetsPath('js/app.js'), compileDistPath('js'))
    .sass(compileAssetsPath('scss/app.scss'), compileDistPath('css'))
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
    .vue()
    .webpackConfig({
        mode: APP_ENV === "dev" ? "development" : "production",
        resolve: {
            extensions: [".js", ".json", ".vue"]
        },
        plugins: [
            new MiniCssExtractPlugin(),
            new VueLoaderPlugin()
        ],
        optimization: {
            minimize: APP_ENV !== "dev",
            minimizer: [
                new TerserPlugin({
                    test: /\.js$/,
                    extractComments: false
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
            icon: compileDistPath('images/logo.png'),
            sound: true,
            wait: true
        });
    });

