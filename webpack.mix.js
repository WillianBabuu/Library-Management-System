const mix = require('laravel-mix');
const path = require('path');

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
mix.alias({
    '@images': path.resolve(__dirname, 'resources/js/images/'),
    '@models': path.resolve(__dirname, 'resources/js/models/'),
    '@enums': path.resolve(__dirname, 'resources/js/models/enums/'),
    '@services': path.resolve(__dirname, 'resources/js/services/'),
    '@sections': path.resolve(__dirname, 'resources/js/sections/'),
    '@components': path.resolve(__dirname, 'resources/js/components/'),
    '@store': path.resolve(__dirname, 'resources/js/store/'),
    '@views': path.resolve(__dirname, 'resources/js/views/'),
    '@layout': path.resolve(__dirname, 'resources/js/views/layout/'),
    /*'@': path.resolve(__dirname, 'resources/js/'),*/
});
/*mix.webpackConfig({
    resolve: {
        alias: {
            '@': __dirname + '/resources/js'
        },
    },
});*/

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ]);
