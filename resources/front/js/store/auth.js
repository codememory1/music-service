import BaseAxios from "../modules/BaseAxios";

export default {
  namespaced: true,

  state: {
    isAuth: false,
    tokens: {
      accessToken: null,
      refreshToken: null
    },
    authUserData: {}
  },

  getters: {
    /**
     *
     * @param state
     * @returns {boolean}
     */
    isAuth(state) {
      return state.isAuth;
    },

    /**
     *
     * @param state
     * @returns {{}}
     */
    getUserData(state) {
      return state.authUserData;
    },

    /**
     *
     * @param state
     * @returns {string}
     */
    getAccessToken(state) {
      return state.tokens.accessToken ?? this.$cookies.get("access_token");
    },

    /**
     *
     * @param state
     * @returns {string}
     */
    getRefreshToken(state) {
      return state.tokens.refreshToken ?? this.$cookies.get("refresh_token");
    }
  },

  mutations: {
    /**
     *
     * @param state
     * @param token
     */
    setAccessToken(state, token) {
      state.tokens.accessToken = token;
    },

    /**
     *
     * @param state
     * @param token
     */
    setRefreshToken(state, token) {
      state.tokens.refreshToken = token;
    }
  },

  actions: {
    /**
     *
     * @param context
     * @returns {Promise<void>}
     */
    async loadUserData(context) {
      try {
        const response = await BaseAxios.get("/user/current", {
          headers: {
            Authorization: `Bearer ${context.getters.getAccessToken}`
          }
        });

        if (response.status === 200) {
          context.state.authUserData = response.data;
          context.state.isAuth = true;
        }
      } catch (e) {
        context.state.isAuth = false;
      }
    }
  }
};
