import { VuexModule, Module, Mutation } from 'vuex-module-decorators';
import AlertInterface from '~/interfaces/ui/alert-interface';

const { v4: uuidv4 } = require('uuid');

@Module({
  name: 'modules/AlertModule',
  stateFactory: true,
  namespaced: true
})
export default class AlertModule extends VuexModule {
  public alerts: Array<AlertInterface> = [];

  @Mutation
  public addAlert(alert: AlertInterface): void {
    alert.id = uuidv4();

    this.alerts.unshift(alert);
  }

  @Mutation
  public removeAlert(alert: AlertInterface): void {
    this.alerts = this.alerts.filter((addedAlert) => {
      return addedAlert.id !== alert.id;
    });
  }
}
