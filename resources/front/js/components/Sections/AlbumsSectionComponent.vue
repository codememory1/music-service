<template>
  <base-section :title="sectionTitle" class="top-albums">
    <!-- Control START -->
    <template v-slot:top>
      <base-slider-navigation
        ref="sliderNavigation"
        @prev="prevSlide"
        @next="nextSlide"
      />
    </template>
    <!-- Control END -->

    <!-- Albums START -->
    <template v-slot:content>
      <div class="albums" role="slider">
        <core-swiper ref="albumsSwiper" :options="swiperOptions">
          <slide-swiper v-for="(album, index) in albums" :key="index">
            <slot name="slider" :album="album" />
          </slide-swiper>
        </core-swiper>
      </div>
    </template>
    <!-- Albums END -->
  </base-section>
</template>
<script>
import BaseSliderNavigation from "../Navigation/BaseSliderNavigationComponent";
import BaseSection from "../Sections/BaseSectionComponent";
import "swiper/css/swiper.css";

export default {
  name: "AlbumSectionComponent",
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
  components: {
	BaseSliderNavigation,
	BaseSection
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
@import "../../../scss/components/sections/albums";
</style>
