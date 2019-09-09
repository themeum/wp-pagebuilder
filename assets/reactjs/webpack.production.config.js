'use strict';

var path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: [
        path.join(__dirname, 'src/main.js')
    ],
    output: {
        path: path.join(__dirname, '../js/'),
        filename: 'engine.js'
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify('production')
        }),
        new webpack.optimize.UglifyJsPlugin()
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader'
                }
            }
        ]
    },
    devtool: false,
    externals : {
        lodash : '_',
        //react : 'React',
        //'react-dom': 'ReactDOM'
    }
};