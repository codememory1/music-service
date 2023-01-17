export default class InputService {
  public actualValue: any;
  private readonly expectedType: string;
  private readonly expectedValue: any;
  private readonly minLength?: number;
  private error: boolean = false;

  public constructor(
    actualValue: any,
    expectedType: string,
    expectedValue: any = undefined,
    minLength: number | undefined = undefined
  ) {
    this.actualValue = actualValue;
    this.expectedType = expectedType;
    this.expectedValue = expectedValue;
    this.minLength = minLength;
  }

  public getValue(): any {
    return this.actualValue;
  }

  public setValue(value: any): InputService {
    this.actualValue = value;

    return this;
  }

  public isError(): boolean {
    return this.error;
  }

  public validate(): boolean {
    const expectingTypeValue = typeof this.actualValue === this.expectedType;
    const expectingValue =
      this.expectedValue === undefined || this.actualValue === this.expectedValue;
    const expectingValueLength =
      this.minLength === undefined || this.actualValue.length >= this.minLength;

    this.error = !(expectingTypeValue && expectingValue && expectingValueLength);

    return !this.error;
  }
}
