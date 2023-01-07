import InputFormDataType from '~/types/ui/form-data/input-form-data-type';

export default class ChangeInputService {
  public change(event: InputEvent, inputFormData: InputFormDataType): void {
    inputFormData.value = String((event.target as HTMLInputElement).value);
  }
}
