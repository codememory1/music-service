<template>
  <base-button
    class="loading-button"
    :class="{ active: isLoading }"
    :is-disabled="isDisabled || isLoading"
    @click="$emit('click')"
  >
    <slot />
  </base-button>
</template>
<script>
import BaseButton from "./BaseButtonComponent";

export default {
  name: "LoadingButtonComponent",
  props: {
    /**
     * Show loader on button
     *
     * @type {Boolean}
     */
    isLoading: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * State disabled button
     *
     * @type {Boolean}
     */
    isDisabled: {
      type: Boolean,
      default: false,
      required: false
    }
  },
  components: {
    BaseButton
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/loadingButton";
</style>
