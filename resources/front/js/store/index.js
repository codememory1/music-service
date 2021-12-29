import Vue from "vue";
import Vuex from "vuex";
import alert from "./alert";
import auth from "./auth";
import layoutScroll from "./layout";
import translation from "./translation";
import account from "./account";
import requestStatuses from "./requestStatuses";
import loading from "./loading";

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
