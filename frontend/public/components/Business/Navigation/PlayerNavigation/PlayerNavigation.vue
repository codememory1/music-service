<template>
  <div class="player-navigation">
    <div class="player-navigation-header">
      <MainLogo img-class="player-navigation__logo" />

      <slot name="header" />
    </div>
    <div class="player-navigation-categories">
      <slot name="categories" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MainLogo from '~/components/Business/Logo/MainLogo.vue';

@Component({
  components: {
    MainLogo
  }
})
export default class PlayerNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/navigation/player-navigation/player-navigation';
</style>
