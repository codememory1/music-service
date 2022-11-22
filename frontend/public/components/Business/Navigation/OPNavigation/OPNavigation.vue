<template>
  <div class="op-navigation">
    <div class="op-navigation-header">
      <MainLogo img-class="op-navigation__logo" />

      <slot name="header" />
    </div>
    <div class="op-navigation-categories">
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
export default class OPNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/navigation/op-navigation/op-navigation';
</style>
