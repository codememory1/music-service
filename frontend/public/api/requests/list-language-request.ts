import ApiRequestService from '~/services/business/api-request-service';
import ListLanguageResponseType from '~/types/business/api-responses/list-language-response-type';
import Routes from '~/api/routes';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import SelectOptionType from '~/types/ui/select/select-option-type';

export default class ListLanguageRequest {
  private readonly requestService: ApiRequestService;
  private data: ListLanguageResponseType = [];

  public constructor(requestService: ApiRequestService) {
    this.requestService = requestService;
  }

  public async request(): Promise<void> {
    const apiResponse = await this.requestService.request<ListLanguageResponseType>(
      Routes.lang.all
    );
    const response = apiResponse.response as ApiSuccessResponseInterface<ListLanguageResponseType>;

    this.data = response.data;
  }

  public getData(): ListLanguageResponseType {
    return this.data;
  }

  public collectToSelect(): Array<SelectOptionType> {
    const options: Array<SelectOptionType> = [];

    this.data.forEach((language) => {
      options.push({
        value: language.code,
        title: language.original_title
      });
    });

    return options;
  }
}
