const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');
const webpack = require('webpack');

module.exports = (env, argv) => {
    const isProduction = argv.mode === 'production';

    return {
        entry: {
            footMatch: './vue/footMatch.js',
            challenge: './vue/challenge.js',
            staffPresence: './vue/staffPresence.js',

        },
        output: {
            path: path.resolve(__dirname, 'assets/js'),
            filename: '[name].js'
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader'
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader'
                },
                {
                    test: /\.css$/,
                    use: [
                        'vue-style-loader',
                        'css-loader'
                    ]
                }
            ]
        },
        plugins: [
            new VueLoaderPlugin(),
            new webpack.DefinePlugin({
                __VUE_OPTIONS_API__: true,
                __VUE_PROD_DEVTOOLS__: false,
            }),
        ],
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm-bundler.js'
            }
        },
        devServer: {
            static: {
                directory: path.join(__dirname, 'assets/js'),
                watch: true
            },
            hot: true,
            open: true,
            liveReload: true
        },
        devtool: isProduction ? 'nosources-source-map' : 'eval-source-map',
    };
};
