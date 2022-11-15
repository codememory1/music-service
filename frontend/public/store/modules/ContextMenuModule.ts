import { Module, VuexModule, Mutation } from 'vuex-module-decorators';
import { ContextMenuType } from '~/types/ContextMenuType';

@Module({
  name: 'modules/ContextMenuModule',
  stateFactory: true,
  namespaced: true
})
export default class ContextMenuModule extends VuexModule {
  public activeContextMenu: ContextMenuType | {} = {};
  public isShowBackwardButton: boolean = false;
  public transition: string = 'none';

  @Mutation
  public setActiveContextMenu(contextMenu: ContextMenuType, transition: string): void {
    this.activeContextMenu = contextMenu;
    this.transition = transition;
  }

  @Mutation
  public setIsShowBackwardButton(is: boolean): void {
    this.isShowBackwardButton = is;
  }
}
