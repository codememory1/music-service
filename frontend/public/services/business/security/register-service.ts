import { Vue } from 'vue-property-decorator';
import ApiRequestService from '~/services/business/api-request-service';
import RegisterFormDataType from '~/types/ui/form-data/register-form-data-type';
import Routes from '~/api/routes';
import ApiFailedResponseInterface from '~/interfaces/business/api-failed-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import RegisteredUserResponseInterface from '~/interfaces/business/api-responses/registered-user-response-interface';

export default class RegisterService {
  private readonly app: Vue;
  private readonly requestService: ApiRequestService;

  public constructor(app: Vue) {
    this.app = app;
    this.requestService = new ApiRequestService(app, app.$i18n.locale);
  }

  public async register(formData: RegisterFormDataType): Promise<void> {
    this.requestService.setData(formData);

    const apiResponse = await this.requestService.request(Routes.security.register);

    if (apiResponse.isError) {
      this.failedRegister(apiResponse.response as ApiFailedResponseInterface);
    } else {
      this.successRegister(
        apiResponse.response as ApiSuccessResponseInterface<RegisteredUserResponseInterface>
      );
    }
  }

  private failedRegister(response: ApiFailedResponseInterface): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.register'),
      message: this.app.$t(response.error.message),
      status: 'error'
    });
  }

  private successRegister(
    response: ApiSuccessResponseInterface<RegisteredUserResponseInterface>
  ): void {
    this.app.$store.commit('modules/alert-module/addAlert', {
      title: this.app.$t('alert.titles.register'),
      message: this.app.$t('alert.messages.success_register'),
      status: 'success'
    });

    this.app.$emit('successRegister', response.data);
  }
}
