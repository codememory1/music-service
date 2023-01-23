<template>
  <section class="wp-information-section">
    <div class="wp-information-section-top">
      <h3 class="wp-information-section__title">{{ title }}</h3>

      <slot name="top" />
    </div>
    <div class="wp-information-section-content">
      <slot name="content" />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class WebPlayerInformationSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/section/wp-information-section.scss';
</style>
