import ApiRequestService from '~/services/business/api-request-service';
import ListSubscriptionResponseType from '~/types/business/api-responses/list-subscription-response-type';
import Routes from '~/api/routes';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';

export default class ListSubscriptionRequest {
  private readonly requestService: ApiRequestService;
  private data: ListSubscriptionResponseType = [];

  public constructor(requestService: ApiRequestService) {
    this.requestService = requestService;
  }

  public async request(): Promise<void> {
    const apiResponse = await this.requestService.request<ListSubscriptionResponseType>(
      Routes.subscription.all
    );
    const response =
      apiResponse.response as ApiSuccessResponseInterface<ListSubscriptionResponseType>;

    this.data = response.data;
  }

  public getData(): ListSubscriptionResponseType {
    return this.data;
  }
}
