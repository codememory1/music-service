export default {
  install(Vue) {
    Vue.prototype.isEmpty = function isEmpty(value) {
      return null === value || "" === value;
    };
  }
};
