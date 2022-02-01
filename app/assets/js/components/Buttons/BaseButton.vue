<template>
  <button
    type="button"
    class="base-button"
    :class="{ disabled: isDisabled }"
    :aria-disabled="isDisabled"
    @click="$emit('click', $event)"
  >
    <slot />
  </button>
</template>

<script>
export default {
  name: "BaseButton",
  props: {
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
