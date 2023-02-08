import InputService from '~/services/ui/input/input-service';

type InputList = { [key: string]: InputService };

export default class ChangeInputService {
  private readonly inputList: InputList;

  public constructor(inputList: InputList) {
    this.inputList = inputList;
  }

  public getInput(inputName: string): InputService {
    return this.inputList[inputName];
  }

  public change(event: InputEvent, inputName: string): void {
    this.inputList[inputName].setValue((event.target as HTMLInputElement).value);
  }

  public inputIsError(inputName: string): boolean {
    return this.inputList[inputName].isError();
  }

  public allFieldsWithoutErrors(): boolean {
    let isOk: boolean = true;

    for (let i = 0; i < Object.keys(this.inputList).length; i++) {
      const input = this.inputList[Object.keys(this.inputList)[i]];

      if (!input.validate() && isOk) {
        isOk = false;
      }
    }

    return isOk;
  }

  public fieldsWithoutError(keys: Array<string>): boolean {
    let isOk: boolean = true;

    for (let i = 0; i < keys.length; i++) {
      const input = this.inputList[keys[i]];

      if (!input.validate() && isOk) {
        isOk = false;
      }
    }

    return isOk;
  }
}
