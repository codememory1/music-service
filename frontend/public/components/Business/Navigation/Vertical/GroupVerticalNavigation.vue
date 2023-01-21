<template>
  <div class="vertical-navigation-group">
    <span v-if="title !== null" class="vertical-navigation-group__title">{{ title }}</span>
    <ul class="vertical-navigation-group-items">
      <slot />
    </ul>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class GroupVerticalNavigation extends Vue {
  @Prop({ required: false, default: null })
  private readonly title!: string | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/vertical/group-vertical-navigation.scss';
</style>
