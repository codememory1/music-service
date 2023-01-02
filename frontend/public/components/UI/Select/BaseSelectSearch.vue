<template>
  <div class="select-search">
    <i class="select-search__icon far fa-search" />
    <input
      type="text"
      class="select-search__input"
      :placeholder="$t('placeholder.search')"
      @input="$emit('input', $event)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectSearch extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-search.scss';
</style>
