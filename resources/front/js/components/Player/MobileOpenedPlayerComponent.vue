<template>
  <div class="opened-mobile-player">
    <div class="window_indicator">
      <div class="window_indicator__border"></div>
    </div>
    <div class="opened-mobile-player__image">
      <img :src="image" :alt="name" />
    </div>
    <div class="opened-mobile-player__info">
      <span class="music__name">{{ name }}</span>
      <span class="music__author">{{ author }}</span>
    </div>
    <div class="opened-mobile-player__times">
      <span class="duration">0:58</span>
      <span class="total">03:58</span>
    </div>
    <progress-bar />
    <div class="opened-mobile-player__control">
      <div class="repeat">
        <svg-alias alias="repeat-svg" />
      </div>
      <div class="opened-mobile-player__control--center">
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
  </div>
</template>
<script>
import ProgressBar from "../BaseRangeComponent";

export default {
  name: "MobileOpenedPlayer",
  components: {
    ProgressBar
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
