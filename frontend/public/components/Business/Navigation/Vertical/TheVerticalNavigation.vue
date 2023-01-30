<template>
  <nav class="vertical-navigation">
    <div class="vertical-navigation-logo-wrapper">
      <PlatformLogo />
    </div>
    <div class="vertical-navigation-groups">
      <slot />
    </div>
  </nav>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PlatformLogo from '~/components/Business/Logo/PlatformLogo.vue';

@Component({
  components: {
    PlatformLogo
  }
})
export default class TheVerticalNavigation extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/navigation/vertical/the-vertical-navigation.scss';
</style>
