import { NuxtApp } from '@nuxt/types/app';
import { ApiRoute } from '~/api/ApiRoute';
import { EnumRequestMethods } from '~/Enums/EnumRequestMethods';

export default function ({ $axios }: NuxtApp, inject: (key: string, value: any) => void) {
  inject('api', (route: ApiRoute) => {
    const lang = 'ru';

    const api = $axios.create({
      baseURL: (process.env.API_URL as string) + `/${lang}/public`,
      url: route.getPath()
    });

    if (route.getMethod() === EnumRequestMethods.Get) {
      return api.$get(route.getPath());
    }

    if (route.getMethod() === EnumRequestMethods.Post) {
      return api.$post(route.getPath());
    }

    if (route.getMethod() === EnumRequestMethods.Put) {
      return api.$put(route.getPath());
    }

    if (route.getMethod() === EnumRequestMethods.Delete) {
      return api.$delete(route.getPath());
    }

    if (route.getMethod() === EnumRequestMethods.Patch) {
      return api.$patch(route.getPath());
    }
  });
}
