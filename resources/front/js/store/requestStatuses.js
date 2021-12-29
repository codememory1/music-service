export default {
  namespaced: true,
  state: {
    translation: false,
    authUserData: false
  },

  getters: {
    /**
     * @param state
     * @returns {boolean|*}
     */
    isCameTranslation: (state) => state.translation,
    isCameAuthUserData: (state) => state.authUserData
  },

  mutations: {
    /**
     * @param state
     * @param status
     */
    setStatusTranslation(state, status) {
      state.translation = status;
    },

    /**
     * @param state
     * @param status
     */
    setStatusAuthUserData(state, status) {
      state.authUserData = status;
    }
  }
};
