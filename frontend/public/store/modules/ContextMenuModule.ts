import { VuexModule, Module, Mutation } from 'vuex-module-decorators';
// import { ContextMenuType } from '~/types/ContextMenuType';

@Module({
  name: 'modules/ContextMenuModule',
  stateFactory: true,
  namespaced: true
})
export default class ContextMenuModule extends VuexModule {
  // public contextMenu: ContextMenuType | {} = {};
  // public isShowBackwardButton: boolean = false;
  //
  // @Mutation
  // public setContextMenu(contextMenu: ContextMenuType): void {
  //   this.contextMenu = contextMenu;
  // }
  //
  // @Mutation
  // public setIsShowBackwardButton(is: boolean): void {
  //   this.isShowBackwardButton = is;
  // }
}
