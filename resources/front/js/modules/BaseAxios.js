import axios from "axios";
import { API_URL } from "../env";
import store from "../store";

const instance = axios.create({
  baseURL: API_URL
});

instance.interceptors.request.use((config) => {
  config.params = {
    lang: store.getters["translation/lang"]
  };

  return config;
});

export default instance;
