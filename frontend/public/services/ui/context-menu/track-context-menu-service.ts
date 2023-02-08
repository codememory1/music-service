import { Vue } from 'vue-property-decorator';
import TrackContextMenu from '~/components/Business/ContextMenu/TrackContextMenu.vue';
import BaseContextMenu from '~/components/Business/ContextMenu/BaseContextMenu.vue';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';

export default class TrackContextMenuService {
  private readonly app: Vue;
  private openContextMenuTrack: TrackResponseInterface | null = null;

  public constructor(app: Vue) {
    this.app = app;
  }

  public open(event: PointerEvent, track: TrackResponseInterface): void {
    const trackContextMenu = this.app.$refs.trackContextMenu as TrackContextMenu;
    const contextMenu = trackContextMenu.$refs.contextMenu as BaseContextMenu;

    contextMenu.contextMenuService.toggle(event, this.app.$refs.main as HTMLElement);

    this.openContextMenuTrack = track;
  }

  public getTrack(): TrackResponseInterface | null {
    return this.openContextMenuTrack;
  }
}
