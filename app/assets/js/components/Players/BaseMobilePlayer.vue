<template>
  <div class="mobile-player">
    <!-- Info START -->
    <div class="mobile-player-info">
      <img class="mobile-player__image" :src="image" :alt="name" />
      <div class="mobile-player-names">
        <span class="mobile-player__track-name">{{ name }}</span>
        <a href="#" class="mobile-player__author">{{ author }}</a>
      </div>
    </div>
    <!-- Info END -->

    <!-- Control START -->
    <div class="mobile-player-control">
      <base-button class="mobile-player__button play-pause">
        <svg-alias alias="pause-svg" />
      </base-button>
      <base-button class="mobile-player__button next">
        <svg-alias alias="next-svg" />
      </base-button>
    </div>
    <!-- Control END -->
  </div>
</template>

<script>
import BaseButton from "../Buttons/BaseButton.vue";

export default {
  name: "BaseMobilePlayer",
  components: {
    BaseButton
  },
  props: {
    /**
     * Track name
     */
    name: {
      type: String,
      require: true
    },

    /**
     * Author track
     */
    author: {
      type: String,
      required: true
    },

    /**
     * Path Track image
     */
    image: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/players/base-mobile-player";
</style>
