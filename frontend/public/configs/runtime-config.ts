import * as process from 'process';

export default {
  privateRuntimeConfig: {
    apiServerHost: process.env.API_SERVER_HOST
  },

  publicRuntimeConfig: {
    title: process.env.SITE_NAME,
    apiClientHost: process.env.API_CLIENT_HOST,
    defaultLang: process.env.DEFAULT_LANG,
    alertAutoDeleteTime: 10,
    langCookieName: 'sm_local'
  }
};
