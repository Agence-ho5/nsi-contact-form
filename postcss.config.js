const cssnanoConfig = {
  preset: ['default', { discardComments: { removeAll: true } }]
};

module.exports = ({ file, options }) => {
  return {
    parser: options.optimize ? 'postcss-safe-parser' : undefined,
    plugins: {
      autoprefixer: true,
      cssnano: options.optimize ? cssnanoConfig : false,
    },
  };
};
