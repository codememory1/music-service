import BaseAxios from "../modules/BaseAxios";

async function response(username, password) {
  try {
    return await BaseAxios.post("/auth", { username, password });
  } catch (e) {
    return e.response;
  }
}

export default response;
