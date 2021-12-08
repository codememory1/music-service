import Cookie from "vue-cookies";
import ConfigModule from "../modules/Config";
import BaseAxios from "../modules/BaseAxios";

export default {
  install(Vue) {
    Vue.use(Cookie);

    BaseAxios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${Vue.$cookies.get(ConfigModule.auth_cookie_name)}`;

    Vue.prototype.$axios = BaseAxios;
  }
};
