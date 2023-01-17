<template>
  <li class="main-navigation__item">
    <nuxt-link v-if="link !== null" class="main-navigation__item-link" :to="link">
      <slot />
    </nuxt-link>
    <a v-else href="#" class="main-navigation__item-link" @click.prevent="$emit('click')">
      <slot />
    </a>

    <slot name="drop-down" />
  </li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class MainItemNavigation extends Vue {
  @Prop({ required: false, default: null })
  private readonly link!: string | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/main/main-item-navigation.scss';
</style>
