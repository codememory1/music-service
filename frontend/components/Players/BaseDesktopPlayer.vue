<template>
  <div class="desktop-player">
    <div class="desktop-player-inner">
      <!-- Top control -->
      <div class="desktop-player-top">
        <base-desktop-player-track-control />
        <base-desktop-player-control />
        <base-desktop-player-volume-control />
      </div>

      <!-- Down control -->
      <div class="desktop-player-down">
        <span class="desktop-player__current-time">00:58</span>
        <span class="desktop-player__time-progress"></span>
        <span class="desktop-player__duration-time">05:18</span>
      </div>
    </div>
  </div>
</template>

<script>
import BaseDesktopPlayerTrackControl from "@/components/Players/BaseDesktopPlayerTrackControl";
import BaseDesktopPlayerControl from "@/components/Players/BaseDesktopPlayerControl";
import BaseDesktopPlayerVolumeControl from "@/components/Players/BaseDesktopPlayerVolumeControl";

export default {
  name: "BaseDesktopPlayer",
  components: {
    BaseDesktopPlayerTrackControl,
    BaseDesktopPlayerControl,
    BaseDesktopPlayerVolumeControl
  }
};
</script>
<style lang="scss">
@import "../../assets/css/components/players/base-desktop-player";
</style>
