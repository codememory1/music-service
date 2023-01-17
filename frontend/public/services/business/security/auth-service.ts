import { Vue } from 'vue-property-decorator';
import ApiRequestService from '~/services/business/api-request-service';
import JwtTokenResponse from '~/interfaces/business/api-responses/jwt-token-response';
import Routes from '~/api/routes';
import ApiFailedResponseInterface from '~/interfaces/business/api-failed-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import AuthorizedUserInfoRequest from '~/api/requests/authorized-user-info-request';
import AuthFormDataType from '~/types/ui/form-data/auth-form-data-type';

export default class AuthService {
  private readonly app: Vue;
  private readonly requestService: ApiRequestService;
  private readonly authorizedUserInfoRequest: AuthorizedUserInfoRequest;

  public constructor(app: Vue) {
    this.app = app;
    this.requestService = new ApiRequestService(app, app.$i18n.locale);
    this.authorizedUserInfoRequest = new AuthorizedUserInfoRequest(
      new ApiRequestService(app, app.$i18n.locale)
    );
  }

  public async auth(formData: AuthFormDataType): Promise<void> {
    const apiResponse = await this.requestService
      .setData(formData)
      .request<JwtTokenResponse>(Routes.security.auth);

    if (apiResponse.isError) {
      this.failedAuth(apiResponse.response as ApiFailedResponseInterface);
    } else {
      await this.successAuth(apiResponse.response as ApiSuccessResponseInterface<JwtTokenResponse>);

      this.app.$emit('successAuth');
    }
  }

  private failedAuth(response: ApiFailedResponseInterface): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.auth'),
      message: this.app.$t(response.error.message),
      status: 'error'
    });
  }

  private async successAuth(
    response: ApiSuccessResponseInterface<JwtTokenResponse>
  ): Promise<void> {
    await this.authorizedUserInfoRequest.request(response.data.access_token);

    if (this.authorizedUserInfoRequest.getData() === undefined) {
      this.app.$store.commit('modules/alert-module/addAlert', {
        title: this.app.$t('alert.titles.auth'),
        message: this.app.$t('alert.messages.error_auth'),
        status: 'error'
      });
    } else {
      this.app.$store.commit('modules/alert-module/addAlert', {
        title: this.app.$t('alert.titles.auth'),
        message: this.app.$t('alert.messages.success_auth'),
        status: 'success'
      });

      window.localStorage.setItem(this.app.$config.lsRefreshTokenName, response.data.refresh_token);
      this.app.$cookies.set(this.app.$config.cookieAccessTokenName, response.data.access_token);

      this.app.$store.commit(
        'modules/global-module/authorizedUserInfo',
        this.authorizedUserInfoRequest.getData()!
      );
    }
  }
}
