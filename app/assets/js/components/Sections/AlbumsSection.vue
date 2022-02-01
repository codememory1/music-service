<template>
  <base-section :title="title" class="top-albums">
    <!-- Control START -->
    <template #top>
      <base-slider-navigation
        ref="sliderNavigation"
        @prev="prevSlide"
        @next="nextSlide"
      />
    </template>
    <!-- Control END -->

    <!-- Albums START -->
    <template #content>
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
import BaseSection from "./BaseSection";
import BaseSliderNavigation from "../Navigations/BaseSliderNavigation";
import "swiper/css/swiper.css";

export default {
  name: "AlbumsSection",
  components: {
    BaseSliderNavigation,
    BaseSection
  },
  props: {
    /**
     * Section title for top
     */
    title: {
      type: String,
      required: true
    },

    /**
     * An array of album objects
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
    /**
     * @returns {Object}
     */
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

<style lang="scss">
@import "../../../scss/components/sections/albums-section";
</style>
