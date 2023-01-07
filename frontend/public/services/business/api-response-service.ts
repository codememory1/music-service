export default class ApiResponseService<R> {
  public readonly isError: boolean;
  public readonly response: R | undefined;

  public constructor(isError: boolean, response: R | undefined) {
    this.isError = isError;
    this.response = response;
  }
}
