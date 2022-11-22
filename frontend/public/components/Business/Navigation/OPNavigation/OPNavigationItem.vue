<template>
  <li class="op-navigation__item">
    <NuxtLink class="op-navigation__item-link" :to="to">
      <i v-if="faIcon !== undefined" class="op-navigation__item-icon" :class="faIcon" />
      {{ title }}
    </NuxtLink>
  </li>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class OPNavigationItem extends Vue {
  @Prop({ required: false })
  private readonly faIcon!: string;

  @Prop({ required: true })
  private readonly to!: string;

  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/navigation/op-navigation/op-navigation-item';
</style>
