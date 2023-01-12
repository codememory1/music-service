import { NuxtAxiosInstance } from '@nuxtjs/axios';
import LanguageService from '~/services/business/language-service';

declare module '@nuxt/types' {
  // eslint-disable-next-line no-unused-vars
  interface Context {
    $api: NuxtAxiosInstance;
    $uuid: string;
    $language: LanguageService;
  }

  // eslint-disable-next-line no-unused-vars
  interface NuxtAppOptions {
    $api: NuxtAxiosInstance;
    $uuid: string;
    $language: LanguageService;
  }
}
