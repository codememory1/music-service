import Vue from "vue";
import Vuex from "vuex";
import alert from "./alert";
import auth from "./auth";
import layoutScroll from "./layout";
import translation from "./translation";
import account from "./account";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    alert,
    auth,
    layoutScroll,
    translation,
    account
  }
});
