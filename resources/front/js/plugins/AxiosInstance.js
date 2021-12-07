import axios from "axios";
import Cookie from "vue-cookies";
import ConfigModule from "../modules/Config";

export default {
  install(Vue) {
    Vue.use(Cookie);

    Vue.prototype.$axios = axios.create({
      baseURL: ConfigModule.api_url,
      headers: {
        Authorization: `Bearer ${Vue.$cookies.get(
          ConfigModule.auth_cookie_name
        )}`
      }
    });
  }
};
