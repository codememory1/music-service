import { Vue } from 'vue-property-decorator';
import ApiRequestService from '~/services/business/api-request-service';
import PasswordRecoveryFormDataType from '~/types/ui/form-data/password-recovery-form-data-type';
import Routes from '~/api/routes';
import ApiFailedResponseInterface from '~/interfaces/business/api-failed-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import PasswordRecoveryResponseInterface from '~/interfaces/business/api-responses/password-recovery-response-interface';

export default class PasswordRecoveryService {
  private readonly app: Vue;
  private readonly requestService: ApiRequestService;

  public constructor(app: Vue) {
    this.app = app;
    this.requestService = new ApiRequestService(app, app.$i18n.locale);
  }

  public async recoveryRequest(formData: PasswordRecoveryFormDataType): Promise<void> {
    this.requestService.setData(formData);

    const apiResponse = await this.requestService.request(
      Routes.security.password_reset.request_restoration
    );

    if (apiResponse.isError) {
      this.failedRecoveryRequest(apiResponse.response as ApiFailedResponseInterface);
    } else {
      this.successRecoveryRequest(
        apiResponse.response as ApiSuccessResponseInterface<PasswordRecoveryResponseInterface>
      );
    }
  }

  private failedRecoveryRequest(response: ApiFailedResponseInterface): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.password_recovery_request'),
      message: this.app.$t(response.error.message),
      status: 'error'
    });
  }

  private successRecoveryRequest(
    response: ApiSuccessResponseInterface<PasswordRecoveryResponseInterface>
  ): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.password_recovery_request'),
      message: this.app.$t('alert.messages.success_password_recovery_request'),
      status: 'success'
    });

    this.app.$emit('successRecoveryRequest', response.data);
  }
}
