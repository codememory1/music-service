interface ApiFailedResponseInterface {
  http_code: number;
  platform_code: number;
  error: {
    message: string;
    message_parameters: Array<string>;
  };
}

export default ApiFailedResponseInterface;
