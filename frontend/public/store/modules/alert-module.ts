import AlertInterface from '~/interfaces/ui/alert-interface';

const { v4: uuidv4 } = require('uuid');

export default {
  namespaced: true,

  state: {
    alerts: []
  },

  getters: {
    alerts(state: any) {
      return state.alerts;
    }
  },

  mutations: {
    addAlert(state: any, alert: AlertInterface): void {
      alert.id = uuidv4();

      state.alerts.unshift(alert);
    },

    removeAlert(state: any, alert: AlertInterface): void {
      state.alerts = state.alerts.filter((addedAlert: AlertInterface) => {
        return addedAlert.id !== alert.id;
      });
    }
  }
};
