import { NuxtApp } from '@nuxt/types/app';

export default function ({ $axios }: NuxtApp, inject: (key: string, value: any) => void) {
  const axios = $axios.create({
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  });

  axios.defaults.withCredentials = false;

  inject('api', axios);
}
