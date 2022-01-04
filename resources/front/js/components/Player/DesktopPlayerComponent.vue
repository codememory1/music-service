<template>
  <div class="player">
    <!-- Player Up controls START -->
    <div class="player-up">
      <!-- Player left buttons START -->
      <div class="player-left-buttons">
        <div class="player__button" v-tooltip="'Like and suggest similar'">
          <svg-alias alias="like-svg" />
        </div>
        <div class="player__button" v-tooltip="'Add to playlist'">
          <svg-alias alias="playlist-svg" />
        </div>
        <div class="player__button" v-tooltip="'Expand player'">
          <svg-alias alias="expand-svg" />
        </div>
      </div>
      <!-- Player left buttons END -->

      <!-- Player center buttons START -->
      <div class="player-center-buttons">
        <div class="repeat" v-tooltip="'Repeat track'">
          <svg-alias alias="repeat-svg" />
        </div>
        <div class="prev">
          <svg-alias alias="prev-svg" />
        </div>
        <div class="play-pause">
          <svg-alias alias="pause-svg" />
        </div>
        <div class="next">
          <svg-alias alias="next-svg" />
        </div>
        <div class="shuffle" v-tooltip="'Shuffle music'">
          <svg-alias alias="shuffle-svg" />
        </div>
      </div>
      <!-- Player center buttons START -->

      <!-- Player right buttons START -->
      <div class="player-right-buttons">
        <div class="min-volume">
          <svg-alias alias="min-volume-svg" />
        </div>
        <base-range class="volume__progress" />
        <div class="max-volume">
          <svg-alias alias="max-volume-svg" />
        </div>
      </div>
      <!-- Player right buttons START -->
    </div>
    <!-- Player Up controls END -->

    <!-- Player Down controls START -->
    <div class="player-down">
      <div class="duration">
        <span>0:58</span>
      </div>
      <base-range class="duration__progress" />
      <div class="total">
        <span>5:18</span>
      </div>
    </div>
    <!-- Player Down controls END -->
  </div>
</template>
<script>
import BaseRange from "../BaseRangeComponent";

export default {
  name: "DesktopPlayerComponent",
  components: {
	BaseRange
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/player";
</style>
