var path = require('path');
var webpack = require('webpack');

config = {
    entry: './App.js',
    output: {path: __dirname + "/dist", filename: 'bundle.js'},
    module: {
        loaders: [
            {
                test: /\.less$/,
                include: /app/,
                exclude: /node_modules/,
                loaders: [
                    'style-loader',
                    'css-loader',
                    'less-loader'
                ]
            },
            {
                test: /.jsx?$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                query: {
                    presets: ['es2015', 'react']
                }
            }
        ]
    }
};
module.exports = config;