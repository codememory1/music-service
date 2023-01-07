<template>
  <div class="progress-step">
    <div class="progress-step__title">
      {{ titles[active] }}
      <span class="progress-step__current">{{ active + 1 }}/{{ titles.length }}</span>
    </div>
    <div class="progress-step-items">
      <div
        v-for="i in titles.length"
        :key="i"
        class="progress-step__item"
        :class="{ active: i - 1 <= active }"
        @click="$emit('changeStep', i - 1)"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseProgressStep extends Vue {
  @Prop({ required: true })
  private readonly titles!: Array<string>;

  @Prop({ required: false, default: 0 })
  private readonly active!: number;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/steep/base-progress-step.scss';
</style>
