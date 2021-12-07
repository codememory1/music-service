<template>
  <div class="player">
    <div class="player__controls-top">
      <div class="player__left-control">
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
      <div class="player__center-control">
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
      <div class="player__right-control">
        <div class="min-volume">
          <svg-alias alias="min-volume-svg" />
        </div>
        <progress-bar class="volume_progress" />
        <div class="max-volume">
          <svg-alias alias="max-volume-svg" />
        </div>
      </div>
    </div>
    <div class="player__controls-bottom">
      <div class="duration">
        <span>0:58</span>
      </div>
      <progress-bar class="duration_progress" />
      <div class="total">
        <span>5:18</span>
      </div>
    </div>
  </div>
</template>
<script>
import ProgressBar from "../BaseRangeComponent";

export default {
  name: "DesktopPlayer",
  components: {
    ProgressBar
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/player";
</style>
