<template>
  <div class="desktop-player">
    <div class="desktop-player-up-control">
      <div class="desktop-player-main-control">
        <base-button
          class="desktop-player__main-control-button like"
          v-tooltip="'Предлагать похожие треки'"
        >
          <svg-alias alias="like-svg" />
        </base-button>
        <base-button
          class="desktop-player__main-control-button playlist"
          v-tooltip="'Добавить в плейлист'"
        >
          <svg-alias alias="playlist-svg" />
        </base-button>
        <base-button
          class="desktop-player__main-control-button expand"
          v-tooltip="'Расширить плеер'"
        >
          <svg-alias alias="expand-svg" />
        </base-button>
      </div>
      <div class="desktop-player-control">
        <base-button
          class="desktop-player__control-button repeat"
          v-tooltip="'Повторить трек'"
        >
          <svg-alias alias="repeat-svg" />
        </base-button>
        <base-button class="desktop-player__control-button prev">
          <svg-alias alias="prev-svg" />
        </base-button>
        <base-button
          class="desktop-player__control-button play-pause bg--accent"
        >
          <svg-alias alias="pause-svg" />
        </base-button>
        <base-button class="desktop-player__control-button next">
          <svg-alias alias="next-svg" />
        </base-button>
        <base-button
          class="desktop-player__control-button shuffle"
          v-tooltip="'Перемешать треки'"
        >
          <svg-alias alias="shuffle-svg" />
        </base-button>
      </div>
      <div class="desktop-player-volume-wrapper">
        <svg-alias alias="min-volume-svg" />
        <base-range class="desktop-player__volume-control" />
        <svg-alias alias="max-volume-svg" />
      </div>
    </div>
    <div class="desktop-player-down-control">
      <span class="desktop-player__current-time">0:58</span>
      <base-range class="desktop-player__time-control" />
      <span class="desktop-player__duration-time">5:18</span>
    </div>
  </div>
</template>

<script>
import BaseButton from "../Buttons/BaseButton";
import BaseRange from "../Ranges/BaseRange";

export default {
  name: "BaseDesktopPlayer",
  components: {
    BaseButton,
    BaseRange
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/players/base-desktop-player";
</style>
