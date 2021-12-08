import axios from "axios";
import ConfigModule from "./Config";

export default axios.create({
  baseURL: ConfigModule.api_url
});
