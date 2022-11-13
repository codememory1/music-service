import { NuxtAxiosInstance } from '@nuxtjs/axios';
import ApiRouters from '~/api/api-routers';
import { Request } from '~/api/requests/Request';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { ResponseResultType } from '~/types/ResponseResultType';
import { AuthorizationResponseType } from '~/api/responses/AuthorizationResponseType';
import { AuthorizationEntryData } from '~/types/ModalEntryData';

export default class AuthorizationRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.security.auth);
  }

  public send(
    host: string,
    data: AuthorizationEntryData
  ): Promise<ResponseResultType<AuthorizationResponseType, ErrorResponseType>> {
    const response = this.axios.$post(this.collectUrl(host, 'ru'), data);

    return this.response<AuthorizationResponseType>(response);
  }
}
