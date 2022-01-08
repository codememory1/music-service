import Vue from "vue";
import router from "./router";
import store from "./store";

// Import Components
import TouchEvents from "vue2-touch-events";
import InlineSvg from "vue-inline-svg";
import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import ImageAlias from "./components/Global/ImageAlias";
import InlineSvgAlias from "./components/Global/InlineSvgAlias";

// Import Plugins
import AxiosInstance from "./plugins/AxiosInstance";
import IsEmpty from "./plugins/IsEmpty";
import Storage from "./plugins/Storage";
import Environment from "./plugins/environment";

// Import Directives
import VTooltip from "v-tooltip";

Vue.use(AxiosInstance);
Vue.use(TouchEvents);
Vue.use(IsEmpty);
Vue.use(Storage);
Vue.use(VTooltip);
Vue.use(Environment);

Vue.component("InlineSvg", InlineSvg);
Vue.component("CoreSwiper", Swiper);
Vue.component("SlideSwiper", SwiperSlide);
Vue.component("ImgAlias", ImageAlias);
Vue.component("SvgAlias", InlineSvgAlias);

Vue.productionTip = false;

new Vue({
  el: "#app",
  router,
  store
});
