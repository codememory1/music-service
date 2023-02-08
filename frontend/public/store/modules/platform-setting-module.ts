import PlatformSettingResponseInterface from '~/interfaces/business/api-responses/platform-setting-response-interface';
import mocks from '~/api/mocks';

export default {
  namespaced: true,

  state: {
    settings: mocks.platform_settings // FIX: Используеются коваые данные - изменить на реальные
  },

  getters: {
    settings(state: any): PlatformSettingResponseInterface {
      return state.settings;
    }
  }
};
