<template>
  <base-section :title="sectionTitle" class="top-albums">
    <template v-slot:top>
      <base-slider-navigation
        ref="sliderNavigation"
        @prev="prevSlide"
        @next="nextSlide"
      />
    </template>
    <template v-slot:content>
      <div class="albums">
        <core-swiper ref="albumsSwiper" :options="swiperOptions">
          <slide-swiper v-for="(album, index) in albums" :key="index">
            <slot name="slider" :album="album" />
          </slide-swiper>
        </core-swiper>
      </div>
    </template>
  </base-section>
</template>
<script>
import BaseSliderNavigation from "../components/Navigation/BaseSliderNavigationComponent";
import BaseSection from "./Sections/BaseSectionComponent";
import "swiper/css/swiper.css";

export default {
  name: "SectionAlbums",
  components: {
    BaseSliderNavigation,
    BaseSection
  },
  props: {
    /**
     * Section title for top
     *
     * @type {String}
     */
    sectionTitle: {
      type: String,
      required: true
    },

    /**
     * An array of album objects
     *
     * @type {Array}
     */
    albums: {
      type: Array,
      required: true
    }
  },

  data: () => ({
    swiperOptions: {
      slidesPerView: 7
    }
  }),

  computed: {
    swiper() {
      return this.$refs.albumsSwiper.$swiper;
    }
  },

  methods: {
    prevSlide() {
      this.swiper.slidePrev();
    },

    nextSlide() {
      this.swiper.slideNext();
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../scss/variables";
.albums {
  width: 100%;
}

.top-albums {
  margin-top: 60px;
}

.swiper-slide {
  display: flex;
  justify-content: center;
}
</style>
