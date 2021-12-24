export default {
  namespaced: true,

  state: {
    isScroll: false
  },

  getters: {
    /**
     *
     * @param state
     * @returns {any}
     */
    isScroll(state) {
      return state.isScroll;
    }
  },

  mutations: {
    /**
     *
     * @param state
     * @param status
     */
    setScroll(state, status) {
      state.isScroll = status;
    }
  }
};
