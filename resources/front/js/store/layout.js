export default {
  namespaced: true,

  state: {
    isScroll: false,
    contentX: 0,
    contentY: 0
  },

  getters: {
    /**
     *
     * @param state
     * @returns {any}
     */
    isScroll(state) {
      return state.isScroll;
    },

    /**
     *
     * @param state
     * @returns {number}
     */
    getContentX(state) {
      return state.contentX;
    },

    /**
     *
     * @param state
     * @returns {number}
     */
    getContentY(state) {
      return state.contentY;
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
    },

    /**
     *
     * @param state
     * @param position
     */
    setContentX(state, position) {
      state.contentX = position;
    },

    /**
     *
     * @param state
     * @param position
     */
    setContentY(state, position) {
      state.contentY = position;
    }
  }
};
