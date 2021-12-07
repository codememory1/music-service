import axios from "axios";
import ConfigModule from "../modules/Config";

export default axios.create({
  baseURL: ConfigModule.api_url,
});
