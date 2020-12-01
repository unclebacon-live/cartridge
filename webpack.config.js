const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    module: {
        rules: [
            {
                test: /\.scss/,
                loader: 'import-glob-loader'
            }
        ]
    }
};
