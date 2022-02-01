import BaseAxios from "../../modules/BaseAxios";
import Cookies from "js-cookie";

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
      return state.tokens.accessToken ?? Cookies.get("access_token");
    },

    /**
     *
     * @param state
     * @returns {string}
     */
    getRefreshToken(state) {
      return state.tokens.refreshToken ?? Cookies.get("refresh_token");
    }
  },

  mutations: {
    /**
     *
     * @param state
     * @param token
     */
    setAccessToken(state, token) {
      Cookies.set("access_token", token, {
        domain: ".music-service.loc"
      });

      state.tokens.accessToken = token;
    },

    /**
     *
     * @param state
     * @param token
     */
    setRefreshToken(state, token) {
      Cookies.set("refresh_token", token, {
        domain: ".music-service.loc"
      });

      state.tokens.refreshToken = token;
    }
  },

  actions: {
    /**
     *
     * @param context
     * @returns {Promise<void>}
     */
    async loadUserData({ getters, state, commit }) {
      try {
        const response = await BaseAxios.get("/user/current", {
          headers: {
            Authorization: `Bearer ${getters.getAccessToken}`
          }
        });

        commit("requestStatuses/setStatusAuthUserData", true, { root: true });

        if (response.status === 200) {
          state.authUserData = response.data;
          state.isAuth = true;
        }
      } catch (e) {
        state.isAuth = false;
      }
    }
  }
};
