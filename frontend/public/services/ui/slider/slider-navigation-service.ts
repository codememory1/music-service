import { Vue } from 'vue-property-decorator';

export default class SliderNavigationService {
  private readonly app: Vue;
  private swiper: any = undefined;
  private prevActive: boolean = false;
  private nextActive: boolean = true;

  public constructor(app: Vue) {
    this.app = app;
  }

  public setSwiper(swiper: any): SliderNavigationService {
    this.swiper = swiper;

    return this;
  }

  public prevIsActive(): boolean {
    return this.prevActive;
  }

  public nextIsActive(): boolean {
    return this.nextActive;
  }

  public onPrevSlide(): void {
    this.swiper.slidePrev();
  }

  public onNextSlide(): void {
    this.swiper.slideNext();
  }

  public onSlideChange(): void {
    this.prevActive = this.swiper.activeIndex > 0;
    this.nextActive = !this.swiper.isEnd;
  }
}
