<template>
  <li class="main-navigation-drop-down__item">
    <nuxt-link v-if="link !== null" class="main-navigation-drop-down__item-link" :to="link">
      <slot />
    </nuxt-link>
    <a v-else class="main-navigation-drop-down__item-link" href="#" @click.prevent="$emit('click')">
      <slot />
    </a>
  </li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class DropDownItemMainNavigation extends Vue {
  @Prop({ required: false, default: null })
  private readonly link!: string | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/main/drop-down-item-main-navigation.scss';
</style>
