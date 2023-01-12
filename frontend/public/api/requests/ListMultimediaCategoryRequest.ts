import ApiRequestService from '~/services/business/api-request-service';
import Routes from '~/api/routes';
import MultimediaCategoryResponseInterface from '~/interfaces/business/api-responses/multimedia-category-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import ListMultimediaCategoryResponseType from '~/types/business/api-responses/list-multimedia-category-response-type';
import SelectOptionType from '~/types/ui/select/select-option-type';

export default class ListMultimediaCategoryRequest {
  private readonly requestService: ApiRequestService;
  private data: Array<MultimediaCategoryResponseInterface> = [];

  public constructor(request: ApiRequestService) {
    this.requestService = request;
  }

  public async request() {
    const apiResponse = await this.requestService.request<ListMultimediaCategoryResponseType>(
      Routes.multimedia.category.all
    );
    const response =
      apiResponse.response as ApiSuccessResponseInterface<ListMultimediaCategoryResponseType>;

    this.data = response.data;
  }

  public collectForSelect(): Array<SelectOptionType> {
    const options: Array<SelectOptionType> = [];

    this.data.forEach((category) => {
      options.push({
        value: String(category.id),
        title: category.title
      });
    });

    return options;
  }
}
