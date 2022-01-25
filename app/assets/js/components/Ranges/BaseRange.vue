<template>
  <vue-slider
    role="progressbar"
    v-model="value"
    :enable-cross="multipleCross"
    :min="min"
    :max="max"
    :interval="steep"
    :tooltip="enabledTooltip ? tooltipType : 'none'"
    :tooltip-placement="mutatedTooltipPositions"
    :tooltip-formatter="tooltipFormat"
  />
</template>

<script>
import VueSlider from "vue-slider-component";

export default {
  name: "BaseRange",
  components: {
    VueSlider
  },
  props: {
    /**
     * Default value for progress
     */
    defaultValue: {
      type: [Number, Array],
      default: 0
    },

    /**
     * Enable cross for multiple progress bar. Prevents one part
     * of the bar from moving if it is larger than the other
     */
    multipleCross: {
      type: Boolean,
      default: true
    },

    /**
     * Minimum value
     */
    min: {
      type: Number,
      default: 0
    },

    /**
     * Maximum value
     */
    max: {
      type: Number,
      default: 100
    },

    /**
     * Step when the bar moves
     */
    steep: {
      type: Number,
      default: 1
    },

    /**
     * Enable tooltip work
     */
    enabledTooltip: {
      type: Boolean,
      default: false
    },

    /**
     * Tooltip type when tooltip is enabled.
     * Kinds: {always, active, none}
     */
    tooltipType: {
      type: String,
      default: "active"
    },

    /**
     * Tooltip position.
     * Views: top, bottom
     */
    tooltipPositions: {
      type: Array,
      default: () => ["top"]
    },

    /**
     * Format (value) tooltip
     */
    tooltipFormat: {
      type: String,
      default: "{value}"
    }
  },

  data: () => ({
    value: 0,
    mutatedTooltipPositions: []
  }),

  created() {
    this.value = this.defaultValue;
    this.mutatedTooltipPositions = this.tooltipPositions;

    if (
      Array.isArray(this.defaultValue) &&
      this.mutatedTooltipPositions.length < this.defaultValue.length
    ) {
      const difference =
        this.defaultValue.length - this.mutatedTooltipPositions.length;

      for (let i = 0; i < difference; i++) {
        this.mutatedTooltipPositions.push(
          this.mutatedTooltipPositions[this.mutatedTooltipPositions.length - 1]
        );
      }
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/ranges/base-range";
</style>
