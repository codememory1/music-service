class Storage {
  create(name, object) {
    window.localStorage.setItem(name, JSON.stringify(object));

    return this;
  }

  getFullValue(name) {
    const item = window.localStorage.getItem(name);

    return null === item || "" === item || undefined === item
      ? {}
      : JSON.parse(item);
  }

  getByKey(name, key, defaultValue = null) {
    const keys = key.split(".");

    let fullValue = this.getFullValue(name);

    keys.forEach((el) => {
      fullValue = fullValue[el];
    });

    return null === fullValue || "" === fullValue || undefined === fullValue
      ? defaultValue
      : fullValue;
  }
}

export default {
  install(Vue) {
    Vue.prototype.$storage = new Storage();
  }
};
