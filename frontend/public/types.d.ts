import { AxiosRequestConfig } from 'axios';
import { ApiRoute } from '~/api/ApiRoute';

declare class VueI18n {
  t(key: string, values?: any[] | { [key: string]: any }): string;
  t(key: string, locale: string, values?: any[] | { [key: string]: any }): string;
}

declare module 'vue/types/vue' {
  interface Vue {
    $api: (host: string, route: ApiRoute, data?: any, config?: AxiosRequestConfig) => any;
    $t: typeof VueI18n.prototype.t;
  }
}

declare module '@nuxt/types' {
  interface Context {
    $api: (host: string, route: ApiRoute, data?: any, config?: AxiosRequestConfig) => any;
  }

  interface NuxtAppOptions {
    $api: (host: string, route: ApiRoute, data?: any, config?: AxiosRequestConfig) => any;
  }
}
