var Encore = require('@symfony/webpack-encore');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
        // directory where compiled assets will be stored
        .setOutputPath('public/build/')
        // public path used by the web server to access the output path
        .setPublicPath('/build')
        // only needed for CDN's or sub-directory deploy
        //.setManifestKeyPrefix('build/')

        /*
         * ENTRY CONFIG
         *
         * Add 1 entry for each "page" of your app
         * (including one that's included on every page - e.g. "app")
         *
         * Each entry will result in one JavaScript file (e.g. app.js)
         * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
         */
        .createSharedEntry('app', './assets/js/app.js')
        .addEntry('fontawesome', '@fortawesome/fontawesome-free/js/all.min.js')
        //.addEntry('page1', './assets/js/page1.js')
        //.addEntry('page2', './assets/js/page2.js')

        // will require an extra script tag for runtime.js
        // but, you probably want this, unless you're building a single-page app
        .enableSingleRuntimeChunk()

        .addPlugin(new MiniCssExtractPlugin({
            //filename: "../css/[name].css"
        }))

        /*
         * FEATURE CONFIG
         *
         * Enable & configure other features below. For a full
         * list of features, see:
         * https://symfony.com/doc/current/frontend.html#adding-more-features
         */
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        // enables hashed filenames (e.g. app.abc123.css)
        .enableVersioning(Encore.isProduction())

        // enables @babel/preset-env polyfills
        .configureBabel(() => {
        }, {
            useBuiltIns: 'usage',
            corejs: 3
        })

        .addLoader({
            test: /\.scss$/,
            use:
                    [
                        {
                            loader: MiniCssExtractPlugin.loader
                        },
                        'css-loader', 'postcss-loader', 'sass-loader'
                    ]
        })
        .addLoader({
            test: /\.js$/,
            exclude: /node_modules/,
            use:
                    [
                        {
                            loader: "babel-loader"
                        }
                    ]
        })
        // enables Sass/SCSS support
        /*.enableSassLoader()
        .enablePostCssLoader()*/
        .autoProvidejQuery()
        .cleanupOutputBeforeBuild()
        ;

module.exports = Encore.getWebpackConfig();
