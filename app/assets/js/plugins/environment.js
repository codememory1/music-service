import * as env from "../env";

export default {
  install(Vue) {
    Vue.prototype.$env = env;
  }
};
