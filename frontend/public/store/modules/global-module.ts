import { Vue } from 'vue-property-decorator';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';

export default {
  namespaced: true,

  state: {
    loaderIsActive: true,
    authorizedUserInfo: null
  },

  getters: {
    loaderIsActive(state: any): boolean {
      return state.loaderIsActive;
    },

    authorizedUserInfo(state: any): AuthorizedUserInfoResponseInterface | null {
      return state.authorizedUserInfo;
    }
  },

  mutations: {
    loaderIsActive(state: any, is: boolean): void {
      state.loaderIsActive = is;
    },

    authorizedUserInfo(state: any, info: AuthorizedUserInfoResponseInterface): void {
      state.authorizedUserInfo = info;
    },

    logout(state: any, app: Vue): void {
      window.localStorage.removeItem(app.$config.lsRefreshTokenName);
      app.$cookies.remove(app.$config.cookieAccessTokenName);

      state.authorizedUserInfo = null;
    }
  }
};
