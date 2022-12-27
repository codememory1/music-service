<template>
  <div class="horizontal-progress-steep">
    <div
      v-for="(title, index) in titles"
      :key="index"
      class="horizontal-progress-steep-item"
      :class="{ active: index <= active }"
    >
      <span class="horizontal-progress-steep-item__title">{{ index + 1 }}. {{ $t(title) }}</span>
      <div class="horizontal-progress-steep-item__strip"></div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseHorizontalProgressSteep extends Vue {
  @Prop({ required: true })
  private readonly titles!: Array<string>;

  @Prop({ required: false, default: 0 })
  private readonly active!: number;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/steep/base-horizontal-progress-steep.scss';
</style>
