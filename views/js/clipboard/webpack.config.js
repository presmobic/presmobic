/**
 * 2017-2019 Buy Addons Team
*
* NOTICE OF LICENSE
*
* This source file is subject to the GNU General Public License version 3
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.opensource.org/licenses/gpl-3.0.html
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@buy-addons.com so we can send you a copy immediately.
*
* @author Buy Addons Team <hatt@buy-addons.com>
* @copyright  2017-2019 Buy Addons Team
* @license   http://www.opensource.org/licenses/gpl-3.0.html  GNU General Public License version 3
* International Registered Trademark & Property of Buy Addons Team
*/
 
const pkg = require('./package.json');
const path = require('path');
const webpack = require('webpack');

const production = process.env.NODE_ENV === 'production' || false;

const banner = `clipboard.js v${pkg.version}
https://zenorocha.github.io/clipboard.js

Licensed MIT © Zeno Rocha`;

module.exports = {
    entry: './src/clipboard.js',
    output: {
        filename: production ? 'clipboard.min.js' : 'clipboard.js',
        path: path.resolve(__dirname, 'dist'),
        library: 'ClipboardJS',
        libraryTarget: 'umd'
    },
    module: {
        rules: [
            {test: /\.js$/, exclude: /node_modules/, loader: 'babel-loader'}
        ]
    },
    plugins: production ? [
            new webpack.optimize.UglifyJsPlugin({
                beautify: false,
                mangle: {
                    screw_ie8: true,
                    keep_fnames: true
                },
                compress: {
                    screw_ie8: true
                },
                comments: false
            }),
            new webpack.BannerPlugin({banner})
        ] : [
            new webpack.BannerPlugin({banner})
        ]
};
