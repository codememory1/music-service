import type { NuxtConfig } from '@nuxt/types';

const config: NuxtConfig = {
  dev: false,
  server: {
    host: '0.0.0.0',
    port: 3000
  },
  router: {
    linkExactActiveClass: 'active-link'
  },
  vue: {
    config: {
      productionTip: false,
      devtools: true
    }
  },

  privateRuntimeConfig: {
    apiServerHost: process.env.API_SERVER_HOST
  },

  publicRuntimeConfig: {
    title: process.env.SITE_NAME,
    apiClientHost: process.env.API_CLIENT_HOST,
    defaultLang: process.env.DEFAULT_LANG,
    alertAutoDeleteTime: 10
  },

  pwa: {
    manifest: {
      name: process.env.SITE_NAME,
      short_name: process.env.SITE_NAME,
      description: '',
      start_url: '/',
      display: 'fullscreen',
      background_color: '#0E1723',
      theme_color: '#070E17',
      lang: process.env.DEFAULT_LANG,
      orientation: 'landscape-primary'
    },

    icon: {
      fileName: 'favicon/icon.png',
      sizes: [64, 120, 144, 152, 192, 328, 512],
      purpose: 'any'
    },

    workbox: {
      // debug: true,
      // dev: true
    }
  },

  head: {
    title: process.env.SITE_NAME,

    htmlAttrs: {
      lang: process.env.DEFAULT_LANG as string
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

  css: ['@/assets/scss/main.scss'],

  plugins: [
    {
      src: '~plugins/vue-slider.ts',
      ssr: false
    },
    '~plugins/tooltip.ts',
    '~plugins/swiper.ts',
    '~plugins/api.ts',
    '~store/index.ts'
  ],

  components: true,

  buildModules: ['@nuxt/typescript-build', '@nuxtjs/pwa'],

  modules: ['@nuxtjs/i18n', '@nuxtjs/sentry', '@nuxtjs/axios', 'portal-vue/nuxt'],

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
  },

  sentry: {
    dsn: 'https://e00d68afca5b44d0bf2d420d6564adcd@o1287257.ingest.sentry.io/4503920999792640'
  }
};

export default config;
