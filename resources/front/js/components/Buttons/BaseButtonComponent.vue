<template>
  <button
    type="button"
    class="base-button"
    :class="{ disabled: isDisabled }"
    :aria-disabled="isDisabled"
    @click="$emit('click')"
  >
    <slot />
  </button>
</template>
<script>
export default {
  name: "BaseButtonComponent",
  props: {
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
  }
};
</script>
<style lang="scss">
@import "../../../scss/variables";
</style>
