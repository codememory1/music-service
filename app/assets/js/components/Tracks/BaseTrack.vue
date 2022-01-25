<template>
  <div
    ref="musicItem"
    class="track"
    @contextmenu.prevent="$emit('contextmenu', $event)"
  >
    <base-track-info :author="author" :name="trackName" :image="image" />

    <div class="track-info-right">
      <span class="track__duration">03:20</span>

      <base-track-actions @clickByAction="$emit('contextmenu', $event, true)" />
    </div>
  </div>
</template>

<script>
import BaseTrackInfo from "./BaseTrackInfo";
import BaseTrackActions from "./BaseTrackActions";

export default {
  name: "BaseTrack",
  components: {
    BaseTrackInfo,
    BaseTrackActions
  },
  props: {
    /**
     * Music image
     */
    image: {
      type: String,
      required: true
    },

    /**
     * Full name of the music
     */
    trackName: {
      type: String,
      required: true
    },

    /**
     * Music author
     */
    author: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/tracks/base-track";
</style>
