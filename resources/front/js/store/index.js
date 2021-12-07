import Vue from "vue";
import Vuex from "vuex";
import notification from "./notification";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    notification
  }
});
