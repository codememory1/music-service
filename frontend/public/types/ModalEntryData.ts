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

export type PasswordRecoveryRequestEntryData = {
  email: string | null;
};

export type ResetPasswordEntryData = {
  email: string | null;
  code: string | null;
  password: string | null;
  password_confirm: string | null;
};
