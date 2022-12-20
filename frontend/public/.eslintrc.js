module.exports = {
  root: true,

  env: {
    node: true
  },

  parser: 'vue-eslint-parser',

  extends: [
    '@nuxtjs',
    'plugin:prettier/recommended',
    'eslint:recommended',
    'plugin:@typescript-eslint/eslint-recommended'
  ],

  parserOptions: {
    parser: '@typescript-eslint/parser',
    sourceType: 'module',
    allowImportExportEverywhere: false,
    codeFrame: true
  },

  rules: {
    'vue/no-v-html': ['off'],
    'comma-dangle': ['error', 'never'],
    'vue/no-unused-components': ['error', { ignoreWhenBindingPresent: true }],
    'vue/no-useless-template-attributes': ['error'],
    'prettier/prettier': ['error', { trailingComma: 'none', singleQuote: true, printWidth: 100 }]
  }
};
