<template>
  <base-button
    class="loading"
    :class="{ active: isLoading }"
    :is-disabled="isDisabled || isLoading"
    @click="$emit('click', $event)"
  >
    <slot />
  </base-button>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
  name: "LoadingButton",
  components: {
    BaseButton
  },
  props: {
    /**
     * Show loader on button
     */
    isLoading: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * State disabled button
     */
    isDisabled: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/buttons/loading-button";
</style>
