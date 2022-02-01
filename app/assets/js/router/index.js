import Vue from "vue";
import VueRouter from "vue-router";
import {pathStartWith} from "../modules/helpers/UrlParser";

let routes;

if(pathStartWith('web-player')) {
  routes = require(`./modules/player`).routes;
} else if (pathStartWith('account')) {
  routes = require(`./modules/account`).routes;
} else {
  routes = require(`./modules/main`).routes;
}

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes
});
