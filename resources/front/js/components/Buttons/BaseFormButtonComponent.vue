<template>
  <button
    class="base-button c-pointer"
    :class="{ 'skeleton-active': $store.getters['loading/isLoading'] }"
    @click="$emit('click')"
  >
    <slot />
  </button>
</template>
<script>
export default {
  name: "BaseFormButton"
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
