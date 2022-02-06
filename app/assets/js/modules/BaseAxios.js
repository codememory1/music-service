import axios from "axios";
import { API_URL } from "../env";
import store from "../store";

const instance = axios.create({
  baseURL: API_URL,
  headers: {
    "X-Requested-With": "XMLHttpRequest"
  }
});

instance.interceptors.request.use((config) => {
  config.baseURL = API_URL + "/" + store.getters["translation/lang"];

  return config;
});

export default instance;
