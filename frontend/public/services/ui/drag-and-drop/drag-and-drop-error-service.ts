export default class DragAndDropErrorService {
  public readonly title: string;
  public readonly message: string;
  public readonly parameters: object;

  public constructor(title: string, message: string, parameters: object) {
    this.title = title;
    this.message = message;
    this.parameters = parameters;
  }
}
