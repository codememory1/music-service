<template>
  <div class="section-header">
    <div class="section-header-inner">
      <h3 class="section__title">{{ title }}</h3>
      <p v-if="description !== undefined" class="section__description">{{ description }}</p>
    </div>

    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseSectionHeader extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: false })
  private readonly description!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/section/base-section-header';
</style>
