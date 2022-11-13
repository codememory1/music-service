export type AuthorizationResponseType = {
  http_code: number;
  platform_code: number;
  data: {
    access_token: string;
    refresh_token: string;
  };
};
