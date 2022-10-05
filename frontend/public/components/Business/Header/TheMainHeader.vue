<template>
  <header class="main-header">
    <div class="main-header-logo">
      <img class="horizontal-logo" src="/images/logo.svg" :alt="$config.title" />
    </div>
    <div class="main-header-navigation">
      <MainNavigation />
      <BaseSelect
        class="main-header__select-lang"
        placeholder="Lang"
        :options="[
          { key: 'en', value: 'En' },
          { key: 'ru', value: 'Ru' }
        ]"
        :active-options="['en']"
      />
    </div>
  </header>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MainNavigation from '~/components/Business/Navigation/MainNavigation.vue';
import BaseSelect from '~/components/UI/Select/BaseSelect.vue';

@Component({
  components: {
    MainNavigation,
    BaseSelect
  }
})
export default class TheMainHeader extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/main-header';
</style>
