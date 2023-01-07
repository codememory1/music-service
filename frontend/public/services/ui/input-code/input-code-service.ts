import { Vue } from 'vue-property-decorator';
import InputCodeSquareService from '~/services/ui/input-code/input-code-square-service';

export default class InputCodeService {
  public readonly app: Vue;
  private squares: Array<InputCodeSquareService> = [];

  public constructor(app: Vue, numberSquares: number) {
    this.app = app;

    this.generateSquares(numberSquares);
  }

  public addSquare(): InputCodeService {
    this.squares.push(new InputCodeSquareService(this));

    return this;
  }

  public getSquares(): Array<InputCodeSquareService> {
    return this.squares;
  }

  public getValue(separator: string = ''): string {
    const values: Array<string> = [];

    this.squares.forEach((square) => {
      values.push(square.getValue());
    });

    return values.join(separator);
  }

  public activeNextSquare(): InputCodeSquareService {
    return this.squares
      .next(
        (el) => el.isActive(),
        (el) => {
          el.setIsActive(false);
        }
      )
      .setIsActive(true);
  }

  public activePrevSquare(): InputCodeSquareService {
    return this.squares
      .prev(
        (el) => el.isActive(),
        (el) => {
          el.setIsActive(false);
        }
      )
      .setIsActive(true);
  }

  public activeSquare(index: number): void {
    this.squares.forEach((square) => {
      square.setIsActive(false);
    });

    this.squares[index].setIsActive(true);
  }

  private generateSquares(number: number): void {
    for (let i = 0; i < number; i++) {
      this.addSquare();
    }
  }
}
