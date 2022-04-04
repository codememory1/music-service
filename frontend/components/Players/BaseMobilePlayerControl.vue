<template>
  <div class="mobile-player-control">
    <button class="mobile-player__button play-pause">
      <svg-alias alias="play" />
    </button>
    <button class="mobile-player__button next">
      <svg-alias alias="next" />
    </button>
  </div>
</template>

<script>
export default {
  name: "BaseMobilePlayerControl"
};
</script>
