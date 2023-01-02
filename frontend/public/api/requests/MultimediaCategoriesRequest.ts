import { NuxtAxiosInstance } from '@nuxtjs/axios';
import { Request } from '~/api/requests/Request';
import ApiRouters from '~/api/api-routers';
import { MultimediaCategoryType } from '~/api/responses/MultimediaCategoryResponseType';

export default class MultimediaCategoriesRequest extends Request {
  constructor(axios: NuxtAxiosInstance) {
    super(axios, ApiRouters.multimedia.category.all);
  }

  public async send(host: string): Promise<Array<MultimediaCategoryType>> {
    const response = await this.axios.$get(this.collectUrl(host, 'ru'));

    return response.data;
  }
}
