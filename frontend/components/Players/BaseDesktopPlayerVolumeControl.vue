<template>
  <div class="desktop-player-volume-control flex">
    <svg-alias
      class="desktop-player-volume-control__min-max-icon min"
      alias="min-volume"
    />
    <span class="desktop-player__volume-progress"></span>
    <svg-alias
      class="desktop-player-volume-control__min-max-icon max"
      alias="max-volume"
    />
  </div>
</template>

<script>
export default {
  name: "BaseDesktopPlayerVolumeControl"
};
</script>
