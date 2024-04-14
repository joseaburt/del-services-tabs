const TerserPlugin = require('terser-webpack-plugin');
const path = require('path');
const glob = require('glob');

module.exports = {
    mode: 'production',
    entry: () => {
        const entries = {};
        const files = glob.sync('./src/**/*.ts');

        files.forEach((file) => {
            const relativePath = path.relative(path.resolve(__dirname, 'src'), file);
            const entryName = relativePath.replace(/\.ts$/, '').replace(/\\/g, '/'); // Remove .ts extension and convert Windows path separators to Unix
            entries[entryName] = './' + file.replace(/^\.\/src\//, './src/').replace(/\\/g, '/');
        });

        console.log(entries);

        return entries;
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'dist'),
    },
    resolve: {
        extensions: ['.ts', '.js'],
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                use: 'ts-loader',
                exclude: /node_modules/,
            },
        ],
    },
    optimization: {
        minimizer: [new TerserPlugin()],
    },
};
