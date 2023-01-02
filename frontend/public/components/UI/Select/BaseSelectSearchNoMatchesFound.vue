<template>
  <p class="select-search__no-matches-found">{{ $t('no_matches_found') }}</p>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectSearchNoMatchesFound extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-search-no-matches-found.scss';
</style>
