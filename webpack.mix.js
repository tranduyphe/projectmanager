const mix = require("laravel-mix");
var path = require('path');
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
            '@resources': path.resolve(__dirname, 'resources/')
        }
    }
});
mix.js("resources/js/app.js", "public/js")
    .vue()
    // .sass('resources/assets/sass/app.scss', 'public/css')
    .postCss("resources/css/app.css", "public/css", [
        //
    ]);
