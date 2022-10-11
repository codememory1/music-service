<template>
  <div class="player-navigation-category">
    <div v-if="title !== undefined" class="player-navigation-category__title" :aria-label="title">
      {{ title }}
    </div>
    <ul class="player-navigation-items">
      <slot />
    </ul>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class PlayerNavigationCategory extends Vue {
  @Prop({ required: false })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '~/assets/scss/business/navigation/player-navigation/player-navigation-category';
</style>
