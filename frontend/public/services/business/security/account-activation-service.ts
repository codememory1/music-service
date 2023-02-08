import { Vue } from 'vue-property-decorator';
import ApiRequestService from '~/services/business/api-request-service';
import AccountActivationFormDataType from '~/types/ui/form-data/account-activation-form-data-type';
import Routes from '~/api/routes';
import ApiFailedResponseInterface from '~/interfaces/business/api-failed-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import ActivatedUserResponseInterface from '~/interfaces/business/api-responses/activated-user-response-interface';

export default class AccountActivationService {
  private readonly app: Vue;
  private readonly requestService: ApiRequestService;

  public constructor(app: Vue) {
    this.app = app;
    this.requestService = new ApiRequestService(app, app.$i18n.locale);
  }

  public async activate(formData: AccountActivationFormDataType): Promise<void> {
    this.requestService.setData(formData);

    const apiResponse = await this.requestService.request(Routes.security.account_activation);

    if (apiResponse.isError) {
      this.failedActivate(apiResponse.response as ApiFailedResponseInterface);
    } else {
      this.successActivate(
        apiResponse.response as ApiSuccessResponseInterface<ActivatedUserResponseInterface>
      );
    }
  }

  private failedActivate(response: ApiFailedResponseInterface): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.account_activation'),
      message: this.app.$t(response.error.message),
      status: 'error'
    });
  }

  private successActivate(
    response: ApiSuccessResponseInterface<ActivatedUserResponseInterface>
  ): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.account_activation'),
      message: this.app.$t('alert.messages.success_account_activate'),
      status: 'success'
    });

    this.app.$emit('successActivate', response.data);
  }
}
