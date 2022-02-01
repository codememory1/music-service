export default {
  namespaced: true,

  state: {
    alerts: [],
    life: 5000
  },

  getters: {
    getAlerts(state) {
      return state.alerts;
    }
  },

  mutations: {
    create(state, payload) {
      state.alerts.push({
        type: payload.type,
        title: payload.title,
        message: payload.message
      });

      // Delete notification after creation
      setTimeout(() => {
        const keys = Object.keys(state.alerts);
        const firstKey = Number(keys[0]);

        state.alerts.splice(firstKey, 1);
      }, state.life);
    },

    setLife(state, life) {
      state.life = life;
    }
  }
};
