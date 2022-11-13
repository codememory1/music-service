export type AuthorizationEntryData = {
  email: string | null;
  password: string | null;
};

export type RegistrationEntryData = {
  pseudonym: string | null;
  email: string | null;
  password: string | null;
  password_confirm: string | null;
};

export type AccountActivationEntryData = {
  email: string;
  code: string;
};
