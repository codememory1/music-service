import Cookies from "js-cookie";

export default function ({ $axios }) {
  const accessToken = Cookies.get("access_token");

  $axios.create({
    baseURL: process.env.API_URL,
    headers: {
      Authorization: `Bearer ${accessToken}`
    }
  });
}
