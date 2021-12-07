export default {
  namespaced: true,

  state: {
    notifications: [],
    life: 5000
  },

  getters: {
    getNotifications(state) {
      return state.notifications;
    }
  },

  mutations: {
    create(state, payload) {
      state.notifications.push({
        type: payload.type,
        title: payload.title,
        message: payload.message
      });

      // Delete notification after creation
      setTimeout(() => {
        const keys = Object.keys(state.notifications);
        const firstKey = Number(keys[0]);

        state.notifications.splice(firstKey, 1);
      }, state.life);
    },

    setLife(state, life) {
      state.life = life;
    }
  }
};
