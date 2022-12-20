import { Module, VuexModule, Mutation, Action } from 'vuex-module-decorators';

@Module({
  name: 'modules/UserModule',
  stateFactory: true,
  namespaced: true
})
export default class UserModule extends VuexModule {
  public accessToken: string | null = null;

  @Mutation
  public setAccessToken(token: string): UserModule {
    this.accessToken = token;

    return this;
  }

  @Mutation
  public setRefreshToken(token: string): UserModule {
    window.localStorage.setItem('_sm/refresh_token', token);

    return this;
  }

  public getRefreshToken(): string | null {
    return window.localStorage.getItem('_sm/refresh_token');
  }

  @Action
  public updateAccessToken(): void {}
}
