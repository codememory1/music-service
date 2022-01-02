import ObjectFromArrayByKey from "../modules/ObjectFromArrayByKey";
import BaseAxios from "../modules/BaseAxios";
import Cookie from "js-cookie";

export default {
  namespaced: true,
  state: {
    lang: null,
    translations: [],
    received: false
  },

  getters: {
    /**
     * Get active lang
     *
     * @param state
     * @returns {string|*}
     */
    lang(state) {
      const langFromCookie = Cookie.get("lang");

      if (
        null === state.lang &&
        (null === langFromCookie || "" === langFromCookie || undefined === langFromCookie)
      ) {
        return "en";
      }

      if (null !== state.lang) {
        return state.lang;
      }

      return langFromCookie;
    },

    /**
     * Get all translations from active lang
     *
     * @param state
     * @returns {[]}
     */
    translations(state) {
      return state.translations;
    },

    /**
     * Get translation by key from active lang
     *
     * @param state
     * @returns {function(*): String}
     */
    translation: (state) => (key) => {
      /**
       * @type {{translation: String}}
       */
      const translation = ObjectFromArrayByKey(state.translations, "key", key);

      return translation.translation ?? "";
    },

    /**
     * Get status received translations
     *
     * @param state
     * @returns {boolean}
     */
    isReceived: (state) => state.received
  },

  mutations: {
    /**
     * Set active lang
     *
     * @param state
     * @param lang
     */
    setLang(state, lang) {
      Cookie.set("lang", lang, {
        domain: ".music-service.loc"
      });

      state.lang = lang;
    }
  },

  actions: {
    /**
     * Set translations by active lang
     *
     * @param context
     * @returns {Promise<void>}
     * @param lang
     */
    async receiveTranslations({ state, getters, commit }, lang) {
      const response = await BaseAxios.get("/language/translations", {
        params: {
          lang: lang ?? getters.lang
        }
      });

      commit("requestStatuses/setStatusTranslation", true, { root: true });

      if (response.status === 200) {
        state.translations = response.data;
        state.received = true;
      }
    }
  }
};
