<template>
  <button
    class="base-button"
    type="button"
    @click="$emit('click')"
  >
    <slot />
  </button>
</template>
<script>
export default {
  name: "BaseButtonComponent"
};
</script>
<style lang="scss">
@import "../../../scss/variables";

.base-button {
  &.skeleton-active {
    width: 170px;
    background-color: $skeleton-bg;
    border-radius: 10px;
    color: transparent;
    height: 39px;
    pointer-events: none;
  }
}
</style>
