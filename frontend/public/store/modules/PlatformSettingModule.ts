import { Module, VuexModule, Action } from 'vuex-module-decorators';
import PlatformSettingResponseInterface from '~/interfaces/business/api-responses/platform-setting-response-interface';

@Module({
  name: 'modules/UserModule',
  stateFactory: true,
  namespaced: true
})
export default class PlatformSettingModule extends VuexModule {
  public settings: PlatformSettingResponseInterface = {};

  @Action
  public getSettings(): void {}
}
