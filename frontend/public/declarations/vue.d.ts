import { NuxtAxiosInstance } from '@nuxtjs/axios';
import LanguageService from '~/services/business/language-service';

declare module 'vue/types/vue' {
  // eslint-disable-next-line no-unused-vars
  interface Vue {
    $api: NuxtAxiosInstance;
    $uuid: string;
    $language: LanguageService;
    $t: typeof VueI18n.prototype.t;
  }
}
