export type PasswordRecoveryRequestResponseType = {
  http_code: number;
  platform_code: number;
  data: {
    user: {
      id: number;
    };
    status: string;
    ttl: string;
    created_at: string;
  };
};
