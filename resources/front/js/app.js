import Vue from "vue";
import router from "./routes";
import store from "./store";

// Import Components
import TouchEvents from "vue2-touch-events";
import InlineSvg from "vue-inline-svg";
import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import ImageAlias from "./components/Globals/ImageAliasComponent";
import InlineSvgAlias from "./components/Globals/InlineSvgAliasComponent";

// Import Plugins
import AxiosInstance from "./plugins/AxiosInstance";
import IsEmpty from "./plugins/IsEmpty";
import Storage from "./plugins/Storage";

// Import Directives
import VTooltip from "v-tooltip";

Vue.use(AxiosInstance);
Vue.use(TouchEvents);
Vue.use(IsEmpty);
Vue.use(Storage);
Vue.use(VTooltip);

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
