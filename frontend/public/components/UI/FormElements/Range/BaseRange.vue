<template>
  <vue-slider
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

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseRange extends Vue {
  @Prop({ required: false, default: 0 })
  private readonly defaultValue!: Array<number> | number;

  @Prop({ required: false, default: true })
  private readonly multipleCross!: boolean;

  @Prop({ required: false, default: 0 })
  private readonly min!: number;

  @Prop({ required: false, default: 100 })
  private readonly max!: number;

  @Prop({ required: false, default: 1 })
  private readonly steep!: number;

  @Prop({ required: false, default: false })
  private readonly enabledTooltip!: boolean;

  @Prop({ required: false, default: 'active' })
  private readonly tooltipType!: string;

  @Prop({ required: false, default: () => ['top'] })
  private readonly tooltipPositions!: Array<string>;

  @Prop({ required: false, default: '{value}' })
  private readonly tooltipFormat!: string;

  private value: Array<number> | number = this.defaultValue;
  private mutatedTooltipPositions: Array<string> = [];

  private created() {
    this.mutatedTooltipPositions = this.tooltipPositions;

    if (
      Array.isArray(this.defaultValue) &&
      this.mutatedTooltipPositions.length < this.defaultValue.length
    ) {
      const difference = this.defaultValue.length - this.mutatedTooltipPositions.length;
      for (let i = 0; i < difference; i++) {
        this.mutatedTooltipPositions.push(
          this.mutatedTooltipPositions[this.mutatedTooltipPositions.length - 1]
        );
      }
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/range/base-range.scss';
</style>
