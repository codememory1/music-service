export default {
  namespaced: true,
  state: {
    loading: true
  },

  getters: {
    /**
     * @param state
     */
    isLoading: (state) => state.loading
  },

  mutations: {
    /**
     * @param state
     * @param status
     */
    setLoading(state, status) {
      state.loading = status;
    }
  }
};
