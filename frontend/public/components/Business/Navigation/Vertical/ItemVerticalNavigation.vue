<template>
  <li class="vertical-navigation__item">
    <nuxt-link v-if="link !== null" class="vertical-navigation__item-link" :to="link">
      <slot />
    </nuxt-link>
    <a v-else class="vertical-navigation__item-link" href="#" @click.prevent="$emit('click')">
      <slot />
    </a>
  </li>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class ItemVerticalNavigation extends Vue {
  @Prop({ required: false, default: null })
  private readonly link!: string | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/vertical/item-vertical-navigation.scss';
</style>
