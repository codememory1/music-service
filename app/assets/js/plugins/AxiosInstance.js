import BaseAxios from "../modules/BaseAxios";
import Cookies from "js-cookie";

export default {
  install(Vue) {
    const accessToken = Cookies.get("access_token");

    BaseAxios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${accessToken}`;

    Vue.prototype.$axios = BaseAxios;
  }
};
