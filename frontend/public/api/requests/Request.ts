import { NuxtAxiosInstance } from '@nuxtjs/axios';
import { ApiRoute } from '~/api/ApiRoute';
import { ResponseResultType } from '~/types/ResponseResultType';
import { ErrorResponseType } from '~/types/ErrorResponseType';

export abstract class Request {
  protected axios: NuxtAxiosInstance;
  protected readonly route: ApiRoute;

  protected constructor(axios: NuxtAxiosInstance, route: ApiRoute) {
    this.axios = axios;
    this.route = route;
  }

  protected collectUrl(host: string, lang?: string): string {
    const language = lang ?? window.localStorage.getItem('lang');

    return `${host}/${language}/public${this.route.getPath()}`;
  }

  protected response<T>(promise: Promise<any>): Promise<ResponseResultType<T, ErrorResponseType>> {
    return new Promise<ResponseResultType<T, ErrorResponseType>>((resolve, reject) => {
      promise
        .then((response) => {
          resolve({ success: response });
        })
        .catch((error) => {
          // eslint-disable-next-line prefer-promise-reject-errors
          reject({ error: error.response.data });
        });
    });
  }
}
