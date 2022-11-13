export type ErrorResponseType = {
  error: {
    http_code: number;
    platform_code: number;
    message: string;
    message_parameters: Array<[]> | object;
  };
};
