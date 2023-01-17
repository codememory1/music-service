import { Vue } from 'vue-property-decorator';
import AlertInterface from '~/interfaces/ui/alert-interface';

export default class AlertService {
  public readonly app: Vue;

  public constructor(app: Vue) {
    this.app = app;
  }

  public getIconByStatus(alert: AlertInterface): string {
    switch (alert.status) {
      case 'success':
        return '/icons/success-circle.svg';
      case 'error':
        return '/icons/error-circle.svg';
      default:
        return '';
    }
  }

  public getAutoDeleteTime(alert: AlertInterface): number {
    return undefined === alert.autoDeleteTime
      ? this.app.$config.alertAutoDeleteTime
      : alert.autoDeleteTime;
  }

  public deleteAlert(alert: AlertInterface): void {
    this.app.$store.commit('modules/alert-module/removeAlert', alert);

    this.app.$emit('close', alert);
  }
}
