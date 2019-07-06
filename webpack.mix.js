const mix = require('laravel-mix')
const path          = require('path')
const { version }   = require('./package.json')
const webpack       = require('webpack')
const WebpackBar    = require('webpackbar')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.webpackConfig({
 devServer: { disableHostCheck: true },
 resolve  : {
   alias: {
     '@'         : path.resolve(__dirname, 'resources/js/admin/'),
     'static'    : path.resolve(__dirname, 'resources/static/'),
     'validators': 'vuelidate/lib/validators',
   },
 },
 plugins: [
   new WebpackBar({ profile: true }),
   new webpack.DefinePlugin({ __VERSION: JSON.stringify(version) }),
 ],
})

mix.extend('vueOptions', (webpackConfig, vueOptions, ...args) => {
 const vueLoader = webpackConfig.module.rules.find((loader) => loader.loader === 'vue-loader')

 vueLoader.options = require('webpack-merge').smart(vueLoader.options, vueOptions)
})

mix.vueOptions({
 transformToRequire: {
   'img'             : 'src',
   'image'           : 'xlink:href',
   'b-img'           : 'src',
   'b-img-lazy'      : ['src', 'blank-src'],
   'b-card'          : 'img-src',
   'b-card-img'      : 'img-src',
   'b-carousel-slide': 'img-src',
   'b-embed'         : 'src',
 },
})

if (mix.inProduction())
  mix.version()
else
  mix.sourceMaps()
