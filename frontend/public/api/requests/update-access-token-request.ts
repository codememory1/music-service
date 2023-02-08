import ApiRequestService from '~/services/business/api-request-service';
import Routes from '~/api/routes';
import JwtTokenResponse from '~/interfaces/business/api-responses/jwt-token-response';
import ApiSuccessResponseInterface from '~/interfaces/business/api-success-response-interface';

export default class UpdateAccessTokenRequest {
  private readonly requestService: ApiRequestService;
  private data: JwtTokenResponse | undefined = undefined;

  public constructor(requestService: ApiRequestService) {
    this.requestService = requestService;
  }

  public async request(refreshToken: string): Promise<void> {
    this.requestService.setData({
      refresh_token: refreshToken
    });

    const apiResponse = await this.requestService.request<JwtTokenResponse>(
      Routes.security.update_access_token
    );

    if (!apiResponse.isError) {
      const response = apiResponse.response as ApiSuccessResponseInterface<JwtTokenResponse>;

      this.data = response.data;
    }
  }

  public getData(): JwtTokenResponse | undefined {
    return this.data;
  }
}
