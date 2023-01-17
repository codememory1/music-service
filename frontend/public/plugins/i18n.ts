import { NuxtConfig } from '@nuxt/types';

export default function ({ app, $cookies, $config }: NuxtConfig) {
  app.i18n.locale = $cookies.get($config.langCookieName) || app.i18n.locale;
}
