import { NuxtAxiosInstance } from '@nuxtjs/axios';
import ApiRouters from '~/api/api-routers';
import { Request } from '~/api/requests/Request';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { ResponseResultType } from '~/types/ResponseResultType';
import { AccountActivationEntryData } from '~/types/ModalEntryData';
import { AccountActivationResponseType } from '~/api/responses/AccountActivationResponseType';

export default class AccountActivationRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.security.account_activation);
  }

  public send(
    host: string,
    data: AccountActivationEntryData
  ): Promise<ResponseResultType<AccountActivationResponseType, ErrorResponseType>> {
    const response = this.axios.$post(this.collectUrl(host, 'ru'), data);

    return this.response<AccountActivationResponseType>(response);
  }
}
