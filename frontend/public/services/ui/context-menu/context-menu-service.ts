import { Vue } from 'vue-property-decorator';
import mouseClick from '~/utils/mouse-click';

export default class ContextMenuService {
  private readonly app: Vue;
  private stateOpen: boolean = false;
  private styles = {
    top: '0',
    left: '0'
  };

  public constructor(app: Vue) {
    this.app = app;
  }

  public isOpen(): boolean {
    return this.stateOpen;
  }

  public getStyles(): object {
    return this.styles;
  }

  public toggle(event: PointerEvent, main: HTMLElement): void {
    this.close();

    setTimeout(() => {
      const { top, left } = mouseClick(
        event,
        this.app.$refs.contextMenu as HTMLElement,
        main,
        { width: 0, height: 260 } // 260 - Height player * 2
      );

      this.styles.top = `${top}px`;
      this.styles.left = `${left}px`;

      this.open();
    }, 300);
  }

  public close(): void {
    this.stateOpen = false;

    this.app.$store.commit('modules/global-module/contentScrollingAllowed', true);
  }

  public open(): void {
    this.stateOpen = true;

    this.app.$store.commit('modules/global-module/contentScrollingAllowed', false);
  }
}
