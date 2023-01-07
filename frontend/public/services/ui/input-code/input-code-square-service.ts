import InputCodeService from '~/services/ui/input-code/input-code-service';

export default class InputCodeSquareService {
  public readonly inputCodeService: InputCodeService;
  private element?: HTMLInputElement = undefined;
  private error: boolean = false;
  private active: boolean = false;
  private value: string = '';

  public constructor(inputCodeService: InputCodeService) {
    this.inputCodeService = inputCodeService;
  }

  public setElement(element: HTMLInputElement): InputCodeSquareService {
    this.element = element;

    return this;
  }

  public setIsError(is: boolean): InputCodeSquareService {
    this.error = is;

    return this;
  }

  public isError(): boolean {
    return this.error;
  }

  public setIsActive(is: boolean): InputCodeSquareService {
    is ? this.element?.focus() : this.element?.blur();

    this.active = is;

    return this;
  }

  public isActive(): boolean {
    return this.active;
  }

  public getValue(): string {
    return this.value;
  }

  public setValue(value: string): InputCodeSquareService {
    this.value = value;

    return this;
  }

  public input(event: HTMLInputElement, index: number): void {
    if (event.value !== null && event.value.length > 0) {
      if (index < this.inputCodeService.getSquares().length - 1) {
        this.inputCodeService.activeNextSquare();
      }

      this.setValue(event.value);
    } else {
      if (index > 0) {
        this.inputCodeService.activePrevSquare();
      }

      this.setValue('');
    }

    this.inputCodeService.app.$emit(
      'change',
      event,
      this.inputCodeService.getValue(),
      this.inputCodeService.getSquares()
    );
  }
}
