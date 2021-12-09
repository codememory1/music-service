import BaseAxios from "../modules/BaseAxios";

export default {
  install(Vue) {
    BaseAxios.defaults.headers.common[
      "Authorization"
    ] = `Bearer ${window.localStorage.getItem("access_token")}`;

    Vue.prototype.$axios = BaseAxios;
  }
};
