import { Vue } from 'vue-property-decorator';

export default class StepModalService {
  public readonly app: Vue;
  private windowTitles: Array<string>;
  private activeWindow: number = 0;

  public constructor(app: Vue, windowTitles: Array<string>) {
    this.app = app;
    this.windowTitles = windowTitles;
  }

  public getActiveWindow(): number {
    return this.activeWindow;
  }

  public isShowPrevButton(): boolean {
    return this.activeWindow > 0;
  }

  public isShowNextButton(): boolean {
    return this.activeWindow < this.windowTitles.length - 1;
  }

  public isLastWindow(): boolean {
    return this.activeWindow === this.windowTitles.length - 1;
  }

  public prev(): StepModalService {
    return this.changeTo(--this.activeWindow);
  }

  public next(): StepModalService {
    return this.changeTo(++this.activeWindow);
  }

  public changeTo(window: number): StepModalService {
    this.activeWindow = window;

    this.app.$emit('changeWindow', this.activeWindow);

    return this;
  }
}
