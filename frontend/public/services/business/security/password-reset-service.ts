import { Vue } from 'vue-property-decorator';
import ApiRequestService from '~/services/business/api-request-service';
import Routes from '~/api/routes';
import ApiFailedResponseInterface from '~/interfaces/business/api-failed-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import PasswordResetFormDataType from '~/types/ui/form-data/password-reset-form-data-type';
import PasswordResetResponseInterface from '~/interfaces/business/api-responses/password-reset-response-interface';

export default class PasswordResetService {
  private readonly app: Vue;
  private readonly requestService: ApiRequestService;

  public constructor(app: Vue) {
    this.app = app;
    this.requestService = new ApiRequestService(app, app.$i18n.locale);
  }

  public async reset(formData: PasswordResetFormDataType): Promise<void> {
    this.requestService.setData(formData);

    const apiResponse = await this.requestService.request(Routes.security.password_reset.restore);

    if (apiResponse.isError) {
      this.failedReset(apiResponse.response as ApiFailedResponseInterface);
    } else {
      this.successReset(
        apiResponse.response as ApiSuccessResponseInterface<PasswordResetResponseInterface>
      );
    }
  }

  private failedReset(response: ApiFailedResponseInterface): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.password_reset'),
      message: this.app.$t(response.error.message),
      status: 'error'
    });
  }

  private successReset(
    response: ApiSuccessResponseInterface<PasswordResetResponseInterface>
  ): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.password_reset'),
      message: this.app.$t('alert.messages.success_password_reset'),
      status: 'success'
    });

    this.app.$emit('successPasswordReset', response.data);
  }
}
