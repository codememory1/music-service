<template>
  <div class="main-footer-row">
    <template v-if="title !== undefined">
      <span class="main-footer-row__title">{{ title }}</span>

      <div class="main-footer-row-items">
        <slot />
      </div>
    </template>
    <template v-else>
      <slot />
    </template>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class MainRowFooter extends Vue {
  @Prop({ required: false, default: undefined })
  private readonly title!: string | undefined;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/footer/main/main-row-footer.scss';
</style>
