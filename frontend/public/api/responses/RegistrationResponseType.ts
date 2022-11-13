export type RegistrationResponseType = {
  http_code: number;
  platform_code: number;
  data: {
    id: number;
    email: string;
    status: string;
    createdAt: string;
    updatedAt: string;
  };
};
