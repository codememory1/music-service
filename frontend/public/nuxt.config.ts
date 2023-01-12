import type { NuxtConfig } from '@nuxt/types';
import serverConfig from './configs/server';
import runtimeConfig from './configs/runtime-config';
import pwaConfig from './configs/pwa';
import metaConfig from './configs/meta';
import linksConfig from './configs/links';
import pluginsConfig from './configs/plugins';
import i18nConfig from './configs/i18n';
import sentryConfig from './configs/sentry';
import nuxtImgConfig from './configs/nuxt-img';

const config: NuxtConfig = {
  dev: false,

  server: serverConfig,

  router: {
    linkExactActiveClass: 'active-link'
  },

  vue: {
    config: {
      productionTip: false,
      devtools: true
    }
  },

  ...runtimeConfig,

  pwa: pwaConfig,

  head: {
    title: process.env.SITE_NAME,

    htmlAttrs: {
      lang: process.env.DEFAULT_LANG as string
    },

    meta: metaConfig,
    link: linksConfig
  },

  css: ['@/assets/scss/main.scss'],

  components: true,
  buildModules: ['@nuxt/typescript-build', '@nuxtjs/pwa', '@nuxt/image'],
  modules: [
    '@nuxtjs/i18n',
    '@nuxtjs/sentry',
    '@nuxtjs/axios',
    'portal-vue/nuxt',
    'cookie-universal-nuxt'
  ],

  plugins: pluginsConfig,

  i18n: i18nConfig,
  sentry: sentryConfig,
  image: nuxtImgConfig
};

export default config;
