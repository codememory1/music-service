import Vue from "vue";
import VueRouter from "vue-router";

const UrlParser = require("tldts");

const subdomain = UrlParser.getSubdomain(window.location.href) || "home";

const { routes } = require(`./${subdomain}`);

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes
});
