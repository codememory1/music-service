import InputCodeService from '~/services/ui/input-code/input-code-service';

export default class InputCodeKeydownService {
  public readonly inputCodeService: InputCodeService;

  public constructor(inputCodeService: InputCodeService) {
    this.inputCodeService = inputCodeService;
  }

  public handle(event: KeyboardEvent): void {
    switch (event.key) {
      case 'ArrowLeft':
        this.arrowLeft();
        break;
      case 'ArrowRight':
        this.arrowRight();
        break;
    }
  }

  private arrowLeft(): void {
    this.inputCodeService.activePrevSquare();
  }

  private arrowRight(): void {
    this.inputCodeService.activeNextSquare();
  }
}
