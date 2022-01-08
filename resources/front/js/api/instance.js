import axios from "axios";
import { API_URL } from "../env";

export default axios.create({
  baseURL: API_URL
});
