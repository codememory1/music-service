import { NuxtAxiosInstance } from '@nuxtjs/axios';

declare module 'vue/types/vue' {
  // eslint-disable-next-line no-unused-vars
  interface Vue {
    $api: NuxtAxiosInstance;
    $uuid: string;
    $t: typeof VueI18n.prototype.t;
  }
}
