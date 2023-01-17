import Vuex from 'vuex';
import Vue from 'vue';
import AlertModule from './modules/alert-module';
import PlatformSettingModule from '~/store/modules/platform-setting-module';
import GlobalModule from '~/store/modules/global-module';

Vue.use(Vuex);

export default () => {
  return new Vuex.Store({
    modules: {
      'modules/alert-module': AlertModule,
      'modules/global-module': GlobalModule,
      'modules/platform-setting-module': PlatformSettingModule
    }
  });
};
