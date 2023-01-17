import { Module, VuexModule, Mutation, Action } from 'vuex-module-decorators';
import { Vue } from 'vue-property-decorator';
import AuthorizedUserInfoResponseInterface from '~/interfaces/business/api-responses/authorized-user-info-response-interface';
import UpdateAccessTokenRequest from '~/api/requests/update-access-token-request';
import ApiRequestService from '~/services/business/api-request-service';

@Module({
  name: 'modules/UserModule',
  stateFactory: true,
  namespaced: true
})
export default class UserModule extends VuexModule {
  // public info: AuthorizedUserInfoResponseInterface | undefined = undefined;
  //
  // @Mutation
  // public setUserInfo(info: AuthorizedUserInfoResponseInterface): UserModule {
  //   this.info = info;
  //
  //   return this;
  // }
  //
  // @Mutation
  // public logout(app: Vue): void {
  //   window.localStorage.removeItem(app.$config.lsRefreshTokenName);
  //   app.$cookies.remove(app.$config.cookieAccessTokenName);
  // }
  //
  // @Action
  // public async updateAccessToken(app: Vue): Promise<void> {
  //   const refreshToken = window.localStorage.getItem(app.$config.lsRefreshTokenName);
  //
  //   if (refreshToken !== null) {
  //     const updateAccessTokenRequest = new UpdateAccessTokenRequest(new ApiRequestService(app));
  //
  //     await updateAccessTokenRequest.request(refreshToken);
  //
  //     if (updateAccessTokenRequest.getData() !== undefined) {
  //       window.localStorage.setItem(
  //         app.$config.lsRefreshTokenName,
  //         updateAccessTokenRequest.getData()!.refresh_token
  //       );
  //       app.$cookies.set(
  //         app.$config.cookieAccessTokenName,
  //         updateAccessTokenRequest.getData()!.access_token
  //       );
  //     } else {
  //       this.logout(app);
  //     }
  //   }
  // }
}
