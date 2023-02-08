<template>
  <section class="information-section">
    <div class="information-section-info">
      <h2 class="information-section__title">{{ title }}</h2>
      <p v-if="description !== null" class="information-section__description">{{ description }}</p>
    </div>

    <div class="information-section-content">
      <slot />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class InformationSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: false, default: null })
  private readonly description!: string | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/section/information-section.scss';
</style>
