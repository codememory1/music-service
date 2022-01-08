<template>
  <div
    class="progress-indicator__item"
    :aria-current="isNext ? 'step' : 'false'"
    :class="{
      active: isActive,
      next: isNext
    }"
    @click="$emit('click', number + 1, label)"
  >
    <span class="progress-indicator__number">{{ number + 1 }}</span>
    <span class="progress-indicator__label">{{ label }}</span>
  </div>
</template>

<script>
export default {
  name: "BaseProgressIndicatorItem",
  props: {
    /**
     * Number Steep
     */
    number: {
      type: Number,
      required: true
    },

    /**
     * Steep Label
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Is active
     */
    isActive: {
      type: Boolean,
      required: true
    },

    /**
     * Is next steep
     */
    isNext: {
      type: Boolean,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/indicators/base-progress-indicator-item";
</style>
