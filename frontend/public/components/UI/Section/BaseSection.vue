<template>
  <section class="section">
    <div class="section-header">
      <h3 class="section__title">{{ title }}</h3>
      <p v-if="description" class="section__description">{{ description }}</p>
    </div>

    <slot />
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: false })
  private readonly description!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/section/base-section';
</style>
