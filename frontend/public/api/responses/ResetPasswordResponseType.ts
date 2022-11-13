export type ResetPasswordResponseType = {
  http_code: number;
  platform_code: number;
  data: {
    user: {
      id: number;
    };
    code: number;
    status: string;
    created_at: string;
    updated_at: string;
  };
};
