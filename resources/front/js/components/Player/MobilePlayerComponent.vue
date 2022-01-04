<template>
  <div class="mobile-player">
    <!-- Music Info START -->
    <div class="mobile-player-left-info">
      <img class="mobile-player__image" :src="image" :alt="name" />
      <div class="music-info">
        <span class="mobile-player-info__name">{{ name }}</span>
        <span class="mobile-player-info__author">{{ author }}</span>
      </div>
    </div>
    <!-- Music Info END -->

    <!-- Control START -->
    <div class="mobile-player-control">
      <base-button class="mobile-player__play-pause">
        <svg-alias alias="pause-bold-svg" />
      </base-button>
      <base-button class="mobile-player__next">
        <svg-alias alias="next-svg" />
      </base-button>
    </div>
    <!-- Control END -->
  </div>
</template>
<script>
import BaseButton from "../Buttons/BaseButtonComponent";

export default {
  name: "MobilePlayer",
  props: {
    /**
     * Active music name
     *
     * @type {String}
     */
    name: {
      type: String,
      require: true
    },

    /**
     * Active music author
     *
     * @type {String}
     */
    author: {
      type: String,
      required: true
    },

    /**
     * Active music image
     *
     * @type {String}
     */
    image: {
      type: String,
      required: true
    }
  },
  components: {
    BaseButton
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/mobilePlayer";
</style>
