<template>
  <span
    class="track__button"
    role="button"
    tabindex="-1"
    @click="$emit('click', $event)"
  >
    <slot />
  </span>
</template>

<script>
export default {
  name: "BaseTrackButton"
};
</script>

<style lang="scss">
@import "../../../scss/components/tracks/base-track-button";
</style>
