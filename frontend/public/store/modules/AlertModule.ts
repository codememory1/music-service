import { VuexModule, Module, Mutation } from 'vuex-module-decorators';
import { AlertType } from '~/types/AlertType';

const { v4: uuidv4 } = require('uuid');

@Module({
  name: 'modules/AlertModule',
  stateFactory: true,
  namespaced: true
})
export default class AlertModule extends VuexModule {
  public alerts: Array<AlertType> = [];

  @Mutation
  public addAlert(alert: AlertType): void {
    alert.id = uuidv4();

    this.alerts.unshift(alert);
  }

  @Mutation
  public removeAlert(alert: AlertType): void {
    this.alerts = this.alerts.filter((addedAlert) => {
      return addedAlert.id !== alert.id;
    });
  }
}
