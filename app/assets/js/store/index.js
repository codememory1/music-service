import Vue from "vue";
import Vuex from "vuex";
import alert from "./modules/alert.js";
import auth from "./modules/auth.js";
import layoutScroll from "./modules/layout.js";
import translation from "./modules/translation.js";
import account from "./modules/account.js";
import requestStatuses from "./modules/requestStatuses.js";
import loading from "./modules/loading.js";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    alert,
    auth,
    layoutScroll,
    translation,
    account,
    requestStatuses,
    loading
  }
});
