import PlatformSettingResponseInterface from '~/interfaces/business/api-responses/platform-setting-response-interface';

export default {
  namespaced: true,

  state: {
    settings: {
      instagram: '',
      twitter: '',
      facebook: ''
    }
  },

  getters: {
    settings(state: any): PlatformSettingResponseInterface | {} {
      return state.settings;
    }
  }
};
