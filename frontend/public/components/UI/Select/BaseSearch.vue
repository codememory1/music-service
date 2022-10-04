<template>
  <div class="select-search">
    <i class="far fa-search" />
    <input
      v-model="inputText"
      type="text"
      class="select-search__input"
      :placeholder="$t('common.search')"
      @input="$emit('input', $event)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSearch extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/ui/select/base-search';
</style>
