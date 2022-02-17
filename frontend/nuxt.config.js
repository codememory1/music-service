export default {
  head: {
    title: "frontend",
    htmlAttrs: {
      lang: "en"
    },
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "" },
      { name: "format-detection", content: "telephone=no" }
    ],
    link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }]
  },

  css: [
    "normalize.css/normalize.css",
    "~/assets/css/normilize",
    "~/assets/css/app"
  ],

  plugins: [
    "~/plugins/is-empty.js",
    "~/plugins/axios.js",
    "~/plugins/v-tooltip.js",
    "~/plugins/inline-svg.js",
    "~/plugins/svg-alias.js",
    "~/plugins/img-alias.js",
    "~/plugins/swiper.js"
  ],

  components: true,

  buildModules: [],

  modules: ["@nuxtjs/axios"],

  build: {}
};
