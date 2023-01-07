import { MultimediaCategoryType } from '~/types/responses/multimedia-category';

export default class MultimediaCategory {
  private readonly id: number;
  private readonly title: string;

  public constructor(data: MultimediaCategoryType) {
    this.id = data.id;
    this.title = data.title;
  }

  public getId(): number {
    return this.id;
  }

  public getTitle(): string {
    return this.title;
  }
}
