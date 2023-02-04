import ApiRequestService from '~/services/business/api-request-service';
import SocialNetworkAuthUrlResponseInterface from '~/interfaces/business/api-responses/social-network-auth-url-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';
import Routes from '~/api/routes';

export default class GoogleAuthUrlRequest {
  private readonly requestService: ApiRequestService;
  private data: SocialNetworkAuthUrlResponseInterface | null = null;

  public constructor(requestService: ApiRequestService) {
    this.requestService = requestService;
  }

  public async request(): Promise<void> {
    const apiResponse = await this.requestService.request(Routes.social_auth.google.url_auth);

    if (apiResponse.isError) {
      this.data = null;
    } else {
      this.data = (
        apiResponse.response as ApiSuccessResponseInterface<SocialNetworkAuthUrlResponseInterface>
      ).data;
    }
  }

  public getData(): SocialNetworkAuthUrlResponseInterface | null {
    return this.data;
  }
}
