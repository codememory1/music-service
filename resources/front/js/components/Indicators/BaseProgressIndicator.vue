<template>
  <div class="progress-indicator">
    <div class="progress-indicator-items">
      <base-progress-indicator-item
        v-for="(label, index) in labels"
        :key="index"
        :is-next="index === getActiveIndex + 1"
        :is-active="index <= getActiveIndex"
        :label="label"
        :number="index"
      />
    </div>
  </div>
</template>

<script>
import { arrayValidator } from "vue-props-validation";
import BaseProgressIndicatorItem from "./BaseProgressIndicatorItem";

export default {
  name: "BaseProgressIndicator",
  components: {
    BaseProgressIndicatorItem
  },
  props: {
    /**
     * Indicator circle labels
     */
    labels: {
      type: Array,
      required: true,
      validator: arrayValidator(String)
    },

    /**
     * Active label index
     */
    activeIndex: {
      type: Number,
      default: 1
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
@import "../../../scss/components/indicators/base-progress-indicator";
</style>
