<template>
  <nav class="main-navigation">
    <ul class="main-navigation-items">
      <slot />
    </ul>
  </nav>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class TheMainNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/main/the-main-navigation.scss';
</style>
