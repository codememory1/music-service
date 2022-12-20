import { NuxtAxiosInstance } from '@nuxtjs/axios';
import ApiRouters from '~/api/api-routers';
import { Request } from '~/api/requests/Request';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { ResponseResultType } from '~/types/ResponseResultType';
import { PasswordRecoveryRequestEntryData } from '~/types/ModalEntryData';
import { PasswordRecoveryRequestResponseType } from '~/api/responses/PasswordRecoveryRequestResponseType';

export default class PasswordRecoveryRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.security.password_reset.request_restoration);
  }

  public send(
    host: string,
    data: PasswordRecoveryRequestEntryData
  ): Promise<ResponseResultType<PasswordRecoveryRequestResponseType, ErrorResponseType>> {
    const response = this.axios.$post(this.collectUrl(host, 'ru'), data);

    return this.response<PasswordRecoveryRequestResponseType>(response);
  }
}
