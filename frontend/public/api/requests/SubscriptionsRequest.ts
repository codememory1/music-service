import { NuxtAxiosInstance } from '@nuxtjs/axios';
import { Request } from '~/api/requests/Request';
import ApiRouters from '~/api/api-routers';
import { SubscriptionsResponseType } from '~/api/responses/SubscriptionResponseType';

export default class SubscriptionsRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.subscription.all);
  }

  public async send(host: string): Promise<Array<SubscriptionsResponseType>> {
    const response = await this.axios.$get(this.collectUrl(host, 'ru'));

    return response.data;
  }
}
