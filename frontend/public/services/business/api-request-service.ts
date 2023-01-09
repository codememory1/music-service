import { Vue } from 'vue-property-decorator';
import { Method } from 'axios';
import Route from '~/api/route';
import { HttpRequestMethodEnum } from '~/enums/http-request-method-enum';
import ApiResponseService from '~/services/business/api-response-service';
import ApiFailedResponseInterface from '~/interfaces/business/api-failed-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';

type RequestPromiseType<D> = Promise<
  ApiResponseService<ApiSuccessResponseInterface<D> | ApiFailedResponseInterface>
>;

export default class ApiRequestService<D> {
  protected readonly app: Vue;
  protected readonly route: Route;
  protected data?: any = undefined;

  public constructor(app: Vue, route: Route) {
    this.app = app;
    this.route = route;
  }

  public getHost(): string {
    if (this.app.$isServer) {
      return this.app.$config.apiServerHost;
    }

    return this.app.$config.apiClientHost;
  }

  protected collectUrl(): string {
    return `${this.getHost()}/${this.app.$i18n.locale}/public/${this.route.getPath()}`;
  }

  public setData(data: any) {
    this.data = data;
  }

  public request(): RequestPromiseType<D> {
    return new Promise((resolve, reject) => {
      const response = this.app.$api.request({
        url: this.collectUrl(),
        method: HttpRequestMethodEnum[this.route.getMethod()] as Method,
        data: this.data
      });

      response
        .then((response) => {
          resolve(
            new ApiResponseService<ApiSuccessResponseInterface<D>>(
              false,
              response.data as ApiSuccessResponseInterface<D>
            )
          );
        })
        .catch((response) => {
          if (response.response === undefined) {
            reject(response);
          } else {
            resolve(
              new ApiResponseService<ApiFailedResponseInterface>(
                true,
                response.response as ApiFailedResponseInterface
              )
            );
          }
        });
    });
  }
}
