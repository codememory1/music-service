<template>
  <div class="progress-indicator">
    <div class="progress-indicator__items">
      <div
        class="progress-indicator__item"
        v-for="(label, index) in labels"
        :key="index"
        :class="{
          active: index <= getActiveIndex,
          next: index === getActiveIndex + 1
        }"
        @click="$emit('click', index + 1, labels[index])"
      >
        <span class="progress-indicator__number">{{ index + 1 }}</span>
        <span class="progress-indicator__label">{{ label }}</span>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "ProgressIndicator",
  props: {
    /**
     * Indicator circle labels
     *
     * @type {Array}
     */
    labels: {
      type: Array,
      required: true
    },

    /**
     * Active label index
     *
     * @type {Number}
     */
    activeIndex: {
      type: Number,
      default: 1,
      required: false
    }
  },

  computed: {
    /**
     * Returns the index of the active indexer
     *
     * @returns {number}
     */
    getActiveIndex() {
      return this.activeIndex - 1;
    }
  }
};
</script>
<style lang="scss">
@import "../../scss/components/progressIndicator";
</style>
