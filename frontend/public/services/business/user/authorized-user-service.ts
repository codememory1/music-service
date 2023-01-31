import { Vue } from 'vue-property-decorator';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';
import UserSessionResponseInterface from '~/interfaces/business/api-responses/user-session-response-interface';
import ListUserNotificationResponseType from '~/types/business/api-responses/list-user-notification-response-type';

export default class AuthorizedUserService {
  private readonly app: Vue;

  public constructor(app: Vue) {
    this.app = app;
  }

  public getAuthorizedUser(): AuthorizedUserInfoResponseInterface | null {
    return this.app.$store.getters['modules/global-module/authorizedUserInfo'];
  }

  public get sessions(): Array<UserSessionResponseInterface> {
    return this.app.$store.getters['modules/global-module/sessions'].filter(
      (session: UserSessionResponseInterface) => {
        return (
          session.access_token !== this.app.$cookies.get(this.app.$config.cookieAccessTokenName)
        );
      }
    );
  }

  public get currentSession(): UserSessionResponseInterface | null {
    const currentAccessToken = this.app.$cookies.get(this.app.$config.cookieAccessTokenName);
    let currentSession: UserSessionResponseInterface | null = null;

    this.sessions.forEach((session) => {
      if (session.access_token === currentAccessToken) {
        currentSession = session;
      }
    });

    return currentSession;
  }

  public get notifications(): ListUserNotificationResponseType {
    return this.app.$store.getters['modules/global-module/notifications'];
  }

  public logout(): void {
    this.app.$store.commit('modules/global-module/logout', this.app);
  }
}
