import axios from "axios";
import ConfigModule from "./Config";
import store from "../store/index";

const instance = axios.create({
  baseURL: ConfigModule.api_url
});

instance.interceptors.request.use((config) => {
  config.params = {
    lang: store.getters["translation/lang"]
  };

  return config;
});

export default instance;
