import { NuxtConfig } from '@nuxt/types';
import { NuxtCookies } from 'cookie-universal-nuxt';
import ApiRequestService from '~/services/business/api-request-service';
import UpdateAccessTokenRequest from '~/api/requests/update-access-token-request';
import AuthorizedUserInfoRequest from '~/api/requests/authorized-user-info-request';

async function updateTokens(
  refreshToken: string,
  app: any,
  $cookies: NuxtCookies,
  $config: NuxtConfig
): Promise<void> {
  const updateAccessTokenRequest = new UpdateAccessTokenRequest(
    new ApiRequestService(app, app.i18n.locale)
  );
  const authorizedUserInfoRequest = new AuthorizedUserInfoRequest(
    new ApiRequestService(app, app.i18n.locale)
  );

  await updateAccessTokenRequest.request(refreshToken);

  if (updateAccessTokenRequest.getData() !== undefined) {
    window.localStorage.setItem(
      $config.lsRefreshTokenName,
      updateAccessTokenRequest.getData()!.refresh_token
    );
    $cookies.set($config.cookieAccessTokenName, updateAccessTokenRequest.getData()!.access_token);

    await authorizedUserInfoRequest.request(updateAccessTokenRequest.getData()!.access_token);

    app.store.commit(
      'modules/global-module/authorizedUserInfo',
      authorizedUserInfoRequest.getData()
    );
  }
}

export default async function ({ app, $cookies, $config }: NuxtConfig) {
  const refreshToken = window.localStorage.getItem($config.lsRefreshTokenName);
  const accessTokenFromCookie = $cookies.get($config.cookieAccessTokenName);

  const authorizedUserInfoRequest = new AuthorizedUserInfoRequest(
    new ApiRequestService(app, app.i18n.locale)
  );

  if (accessTokenFromCookie !== undefined) {
    await authorizedUserInfoRequest.request(accessTokenFromCookie);

    const userInfo = authorizedUserInfoRequest.getData();

    if (userInfo !== undefined) {
      app.store.commit('modules/global-module/authorizedUserInfo', userInfo);
    } else if (refreshToken !== null) {
      await updateTokens(refreshToken, app, $cookies, $config);
    }
  } else if (refreshToken !== null) {
    await updateTokens(refreshToken, app, $cookies, $config);
  }

  app.store.commit('modules/global-module/loaderIsActive', false);
}
