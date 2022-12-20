export type AccountActivationResponseType = {
  http_code: number;
  platform_code: number;
  data: {
    id: number;
    email: string;
    status: string;
    created_at: string;
    updated_at: string;
  };
};
