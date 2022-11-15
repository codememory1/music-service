import { Store } from 'vuex';
import { getModule } from 'vuex-module-decorators';
import AlertModule from './modules/AlertModule';
import UserModule from '~/store/modules/UserModule';
import ContextMenuModule from '~/store/modules/ContextMenuModule';

export function getAlertModule(store: Store<any>): AlertModule {
  return getModule(AlertModule, store);
}

export function getUserModule(store: Store<any>): UserModule {
  return getModule(UserModule, store);
}

export function getContextMenuModule(store: Store<any>): ContextMenuModule {
  return getModule(ContextMenuModule, store);
}
