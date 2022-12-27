import { InputType } from '~/types/InputType';
import { CheckboxType } from '~/types/CheckboxType';

export type RegisterType = {
  pseudonym: InputType;
  email: InputType;
  password: InputType;
  confirmPassword: InputType;
  isAccept: CheckboxType;
};
