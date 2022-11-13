import { Store } from 'vuex';
import { getModule } from 'vuex-module-decorators';
import AlertModule from './modules/AlertModule';
import UserModule from '~/store/modules/UserModule';

export function getAlertModule(store: Store<any>): AlertModule {
  return getModule(AlertModule, store);
}

export function getUserModule(store: Store<any>): UserModule {
  return getModule(UserModule, store);
}
