<template>
  <div class="op-navigation-category">
    <div v-if="title !== undefined" class="op-navigation-category__title" :aria-label="title">
      {{ title }}
    </div>
    <ul class="op-navigation-items">
      <slot />
    </ul>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class OPNavigationCategory extends Vue {
  @Prop({ required: false })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/navigation/op-navigation/op-navigation-category';
</style>
