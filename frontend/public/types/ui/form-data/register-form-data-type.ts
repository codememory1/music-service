import InputFormDataType from '~/types/ui/form-data/input-form-data-type';
import CheckboxFormDataType from '~/types/ui/form-data/checkbox-form-data-type';

type RegisterFormDataType = {
  pseudonym: InputFormDataType;
  email: InputFormDataType;
  password: InputFormDataType;
  confirmPassword: InputFormDataType;
  isAccept: CheckboxFormDataType;
};

export default RegisterFormDataType;
