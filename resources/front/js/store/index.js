import Vue from "vue";
import Vuex from "vuex";
import notification from "./notification";
import auth from "./auth";
import layoutScroll from "./layout";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    notification,
    auth,
    layoutScroll
  }
});
