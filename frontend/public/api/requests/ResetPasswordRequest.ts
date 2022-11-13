import { NuxtAxiosInstance } from '@nuxtjs/axios';
import ApiRouters from '~/api/api-routers';
import { Request } from '~/api/requests/Request';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { ResponseResultType } from '~/types/ResponseResultType';
import { ResetPasswordEntryData } from '~/types/ModalEntryData';
import { ResetPasswordResponseType } from '~/api/responses/ResetPasswordResponseType';

export default class ResetPasswordRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.security.password_reset.restore);
  }

  public send(
    host: string,
    data: ResetPasswordEntryData
  ): Promise<ResponseResultType<ResetPasswordResponseType, ErrorResponseType>> {
    const response = this.axios.$post(this.collectUrl(host, 'ru'), data);

    return this.response<ResetPasswordResponseType>(response);
  }
}
