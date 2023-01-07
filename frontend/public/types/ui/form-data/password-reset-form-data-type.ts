import InputFormDataType from '~/types/ui/form-data/input-form-data-type';

type PasswordResetFormDataType = {
  codes: InputFormDataType;
  password: InputFormDataType;
  confirmPassword: InputFormDataType;
};

export default PasswordResetFormDataType;
