import ApiRequestService from '~/services/business/api-request-service';
import Routes from '~/api/routes';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';

export default class AuthorizedUserInfoRequest {
  private readonly requestService: ApiRequestService;
  private data: AuthorizedUserInfoResponseInterface | undefined = undefined;

  public constructor(requestService: ApiRequestService) {
    this.requestService = requestService;
  }

  public async request(accessToken: string): Promise<void> {
    const apiResponse = await this.requestService
      .addAuthorizationToken(accessToken)
      .request<AuthorizedUserInfoResponseInterface>(Routes.user.authorized_info);

    if (apiResponse.isError) {
      this.data = undefined;
    } else {
      this.data = (
        apiResponse.response as ApiSuccessResponseInterface<AuthorizedUserInfoResponseInterface>
      ).data;
    }
  }

  public getData(): AuthorizedUserInfoResponseInterface | undefined {
    return this.data;
  }
}
