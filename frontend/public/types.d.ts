import { NuxtAxiosInstance } from '@nuxtjs/axios';

declare class VueI18n {
  t(key: string, values?: any[] | { [key: string]: any }): string;
  t(key: string, locale: string, values?: any[] | { [key: string]: any }): string;
}

declare module 'vue/types/vue' {
  interface Vue {
    $api: NuxtAxiosInstance;
    $uuid: string;
    $t: typeof VueI18n.prototype.t;
  }
}

declare module '@nuxt/types' {
  interface Context {
    $api: NuxtAxiosInstance;
    $uuid: string;
  }

  interface NuxtAppOptions {
    $api: NuxtAxiosInstance;
    $uuid: string;
  }
}
