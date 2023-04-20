const mix = require("laravel-mix");
var path = require('path');
const webpack = require('webpack');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/')
        }
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env': {
                APP_URL: JSON.stringify(process.env.APP_URL),
                PUBLIC_URL: JSON.stringify(process.env.PUBLIC_URL),
            }
        })
    ]
});
mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/app.css", "public/css", [
        //
    ])
    .postCss("resources/css/datatable.css", "public/css", [
        //
    ]);
