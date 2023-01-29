import { Vue } from 'vue-property-decorator';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';
import UserSessionResponseInterface from '~/interfaces/business/api-responses/user-session-response-interface';
import mocks from '~/api/mocks';
import ListUserNotificationResponseType from '~/types/business/api-responses/list-user-notification-response-type';

export default {
  namespaced: true,

  state: {
    loaderIsActive: true,
    authorizedUserInfo: null,
    sessions: mocks.authorized_user.sessions, // FIX: Используются мокавые данные - изменить на реальные, которые будут загружаться после авторизации и через какое-то время обновляться или же загружаться с помощью WebSocket
    notifications: mocks.authorized_user.notifications // FIX: Изменить на реальные уведомления пользователя
  },

  getters: {
    loaderIsActive(state: any): boolean {
      return state.loaderIsActive;
    },

    authorizedUserInfo(state: any): AuthorizedUserInfoResponseInterface | null {
      return state.authorizedUserInfo;
    },

    sessions(state: any): Array<UserSessionResponseInterface> {
      return state.sessions;
    },

    notifications(state: any): ListUserNotificationResponseType {
      return state.notifications;
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
    },

    sessions(state: any, sessions: Array<UserSessionResponseInterface>): void {
      state.sessions = sessions;
    },

    notifications(state: any, notifications: ListUserNotificationResponseType): void {
      state.notifications = notifications;
    }
  }
};
