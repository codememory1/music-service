<template>
  <div class="player-navigation">
    <div class="player-navigation-header">
      <img
        class="player-navigation__logo horizontal-logo"
        src="/images/logo.svg"
        :alt="$config.title"
      />

      <slot name="header" />
    </div>
    <div class="player-navigation-categories">
      <slot name="categories" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class PlayerNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/player-navigation/player-navigation';
</style>
