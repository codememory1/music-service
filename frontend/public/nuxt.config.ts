import type { NuxtConfig } from '@nuxt/types';

const config: NuxtConfig = {
  dev: true,
  server: {
    host: '0.0.0.0',
    port: 3000
  },

  head: {
    title: 'Sumron Music',

    htmlAttrs: {
      lang: 'en'
    },

    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' },
      {
        name: 'og:site_name',
        property: 'og:site_name',
        content: 'Sumron Music'
      },
      { name: 'og:type', property: 'og:type', content: 'website' }
    ],

    link: [
      {
        rel: 'apple-touch-icon',
        sizes: '180x180',
        href: '/favicon/apple-touch-icon.png'
      },
      {
        rel: 'icon',
        type: 'image/png',
        sizes: '32x32',
        href: '/favicon/favicon-32x32.png'
      },
      {
        rel: 'icon',
        type: 'image/png',
        sizes: '16x16',
        href: '/favicon/favicon-16x16.png'
      },
      {
        rel: 'mask-icon',
        href: '/favicon/safari-pinned-tab.svg',
        color: '#E03E10'
      }
    ]
  },

  css: ['normalize.css'],

  plugins: [],

  components: true,

  buildModules: ['@nuxt/typescript-build'],

  modules: ['@nuxtjs/i18n'],

  i18n: {
    langDir: 'i18n/',
    defaultLocale: 'en',
    locales: [
      {
        code: 'en',
        iso: 'en-US',
        file: 'en-US.ts',
        name: 'English'
      }
    ]
  }
};

export default config;
