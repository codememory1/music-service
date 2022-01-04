<template>
  <div class="opened-mobile-player">
    <!-- Indicator START -->
    <div class="window-indicator">
      <span class="window-indicator__border"></span>
    </div>
    <!-- Indicator END -->

    <img class="opened-mobile-player__image" :src="image" :alt="name" />

    <!-- Info START -->
    <div class="opened-mobile-player-info">
      <span class="music__name">{{ name }}</span>
      <span class="music__author">{{ author }}</span>
    </div>
    <!-- Info END -->

    <!-- Times START -->
    <div class="opened-mobile-player-times">
      <span class="duration">0:58</span>
      <span class="total">03:58</span>
    </div>
    <!-- Times END -->

    <base-range />

    <!-- Control START -->
    <div class="opened-mobile-player-control">
      <div class="repeat">
        <svg-alias alias="repeat-svg" />
      </div>
      <div class="opened-mobile-player-control-center">
        <div class="prev">
          <svg-alias alias="prev-svg" />
        </div>
        <div class="play-pause">
          <svg-alias alias="pause-svg" />
        </div>
        <div class="next">
          <svg-alias alias="next-svg" />
        </div>
      </div>
      <div class="shuffle">
        <svg-alias alias="shuffle-svg" />
      </div>
    </div>
    <!-- Control END -->
  </div>
</template>
<script>
import BaseRange from "../BaseRangeComponent";

export default {
  name: "MobileOpenedPlayerComponent",
  components: {
    BaseRange
  },
  props: {
    /**
     * Active music name
     *
     * @type {String}
     */
    name: {
      type: String,
      required: true
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
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/openedMobilePlayer";
</style>
