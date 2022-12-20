import { NuxtAxiosInstance } from '@nuxtjs/axios';
import ApiRouters from '~/api/api-routers';
import { Request } from '~/api/requests/Request';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { ResponseResultType } from '~/types/ResponseResultType';
import { RegistrationEntryData } from '~/types/ModalEntryData';
import { RegistrationResponseType } from '~/api/responses/RegistrationResponseType';

export default class RegistrationRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.security.register);
  }

  public send(
    host: string,
    data: RegistrationEntryData
  ): Promise<ResponseResultType<RegistrationResponseType, ErrorResponseType>> {
    const response = this.axios.$post(this.collectUrl(host, 'ru'), data);

    return this.response<RegistrationResponseType>(response);
  }
}
