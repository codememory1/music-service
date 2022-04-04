<template>
  <div class="desktop-player-track-control flex">
    <button class="desktop-player-track-control__button">
      <svg-alias alias="like" />
    </button>
    <button class="desktop-player-track-control__button">
      <svg-alias alias="playlist" />
    </button>
    <button class="desktop-player-track-control__button">
      <svg-alias alias="expand-player" />
    </button>
  </div>
</template>

<script>
export default {
  name: "BaseDesktopPlayerTrackControl"
};
</script>
