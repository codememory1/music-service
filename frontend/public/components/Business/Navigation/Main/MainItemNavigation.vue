<template>
  <li class="main-navigation__item">
    <nuxt-link v-if="link !== null" class="main-navigation__item-link" :to="link">
      {{ title }}
    </nuxt-link>
    <a
      v-if="null === link"
      href="#"
      class="main-navigation__item-link"
      @click.prevent="$emit('click')"
    >
      {{ title }}
    </a>
  </li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class MainItemNavigation extends Vue {
  @Prop({ required: false, default: null })
  private readonly link!: string | null;

  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/main/main-item-navigation.scss';
</style>
