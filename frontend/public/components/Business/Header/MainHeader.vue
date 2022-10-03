<template>
  <header class="main-header">
    <div class="main-header-logo">
      <img class="horizontal-logo" src="/images/logo.svg" :alt="$config.title" />
    </div>
    <div class="main-header-navigation">
      <MainNavigation />
      <div class="main-header__select-lang">
        <!-- TODO: Тут должен быть select с языками -->
      </div>
    </div>
  </header>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MainNavigation from '~/components/Business/Navigation/MainNavigation.vue';

@Component({
  components: {
    MainNavigation
  }
})
export default class MainHeader extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/main-header';
</style>
