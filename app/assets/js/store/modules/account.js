export default {
  namespaced: true,
  state: {
    pageTitle: null
  },

  getters: {
    /**
     * @param state
     * @returns {any}
     */
    pageTitle: (state) => state.pageTitle
  },

  mutations: {
    /**
     * @param state
     * @param title
     */
    setPageTitle(state, title) {
      state.pageTitle = title;
    }
  }
};
