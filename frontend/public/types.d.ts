import { ApiRoute } from '~/api/ApiRoute';

declare class VueI18n {
  t(key: string, values?: any[] | { [key: string]: any }): string;
  t(key: string, locale: string, values?: any[] | { [key: string]: any }): string;
}

declare module 'vue/types/vue' {
  interface Vue {
    $api: (route: ApiRoute) => any;
    $t: typeof VueI18n.prototype.t;
  }
}

declare module '@nuxt/types' {
  interface Context {
    $api: (route: ApiRoute) => any;
  }

  interface NuxtAppOptions {
    $api: (route: ApiRoute) => void;
  }
}
