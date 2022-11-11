import { NuxtApp } from '@nuxt/types/app';
import { AxiosRequestConfig } from 'axios';
import { ApiRoute } from '~/api/ApiRoute';
import { EnumRequestMethods } from '~/Enums/EnumRequestMethods';

export default function ({ $axios }: NuxtApp, inject: (key: string, value: any) => void) {
  inject('api', (host: string, route: ApiRoute, data?: any, config?: AxiosRequestConfig) => {
    console.log(host)
    const api = $axios.create({
      baseURL: host + '/ru/public'
    });

    if (route.getMethod() === EnumRequestMethods.Get) {
      return api.$get(route.getPath());
    }

    if (route.getMethod() === EnumRequestMethods.Post) {
      return api.$post(route.getPath(), data, config);
    }

    if (route.getMethod() === EnumRequestMethods.Put) {
      return api.$put(route.getPath(), data, config);
    }

    if (route.getMethod() === EnumRequestMethods.Delete) {
      return api.$delete(route.getPath(), config);
    }

    if (route.getMethod() === EnumRequestMethods.Patch) {
      return api.$patch(route.getPath(), data, config);
    }
  });
}
