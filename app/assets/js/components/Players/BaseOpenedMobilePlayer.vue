<template>
  <div class="opened-mobile-player">
    <!-- Indicator START -->
    <div class="window-indicator">
      <span class="window-indicator__line"></span>
    </div>
    <!-- Indicator END -->

    <img class="opened-mobile-player__image" :src="image" :alt="name" />

    <!-- Info START -->
    <div class="opened-mobile-player-info">
      <span class="opened-mobile-player__track-name">{{ name }}</span>
      <span class="opened-mobile-player__author">{{ author }}</span>
    </div>
    <!-- Info END -->

    <!-- Times START -->
    <div class="opened-mobile-player-times">
      <span class="opened-mobile-player__current-time">0:58</span>
      <span class="opened-mobile-player__duration-time">03:58</span>
    </div>
    <!-- Times END -->

    <base-range />

    <!-- Control START -->
    <div class="opened-mobile-player-control">
      <base-button class="opened-mobile-player__button repeat">
        <svg-alias alias="repeat-svg" />
      </base-button>

      <div class="opened-mobile-player-control-center">
        <base-button class="opened-mobile-player__button prev">
          <svg-alias alias="prev-svg" />
        </base-button>
        <base-button class="opened-mobile-player__button play-pause">
          <svg-alias alias="pause-svg" />
        </base-button>
        <base-button class="opened-mobile-player__button next">
          <svg-alias alias="next-svg" />
        </base-button>
      </div>

      <base-button class="opened-mobile-player__button shuffle">
        <svg-alias alias="shuffle-svg" />
      </base-button>
    </div>
    <!-- Control END -->
  </div>
</template>

<script>
import BaseRange from "../Ranges/BaseRange.vue";
import BaseButton from "../Buttons/BaseButton.vue";

export default {
  name: "BaseOpenedMobilePlayer",
  components: {
    BaseRange,
    BaseButton
  },
  props: {
    /**
     * Track name
     */
    name: {
      type: String,
      required: true
    },

    /**
     * Author track
     */
    author: {
      type: String,
      required: true
    },

    /**
     * Path track image
     */
    image: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/players/base-opened-mobile-player";
</style>
