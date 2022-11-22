<template>
  <section class="setting-section">
    <h3 class="setting-section__title">{{ title }}</h3>

    <div class="setting-section-content">
      <slot />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseSettingSection extends Vue {
  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/section/base-setting-section';
</style>
