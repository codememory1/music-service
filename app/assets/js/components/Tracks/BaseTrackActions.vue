<template>
  <div class="track-actions">
    <base-track-button>
      <svg-alias class="track__button-like" alias="like-svg" />
    </base-track-button>
    <base-track-button @click="$emit('clickByAction', $event)">
      <svg-alias class="track__button-action" alias="vertical-ellipses-svg" />
    </base-track-button>
  </div>
</template>

<script>
import BaseTrackButton from "./BaseTrackButton";

export default {
  name: "BaseTrackActions",
  components: {
    BaseTrackButton
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/tracks/base-track-actions";
</style>
