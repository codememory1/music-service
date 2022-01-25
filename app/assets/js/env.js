const APP_NAME = "Music Service";
const APP_URL = process.env.MIX_APP_URL;
const PLAYER_URL = APP_URL + '/web-player';
const API_URL = APP_URL + '/api/v1';
const AUTH_COOKIE_NAME = "access_token";

export { APP_NAME, APP_URL, PLAYER_URL, API_URL, AUTH_COOKIE_NAME };
