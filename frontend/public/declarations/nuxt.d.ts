import { NuxtAxiosInstance } from '@nuxtjs/axios';

declare module '@nuxt/types' {
  // eslint-disable-next-line no-unused-vars
  interface Context {
    $api: NuxtAxiosInstance;
    $uuid: string;
  }

  // eslint-disable-next-line no-unused-vars
  interface NuxtAppOptions {
    $api: NuxtAxiosInstance;
    $uuid: string;
  }
}
