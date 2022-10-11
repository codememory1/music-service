<template>
  <div class="artist-header__search">
    <i class="artist-header__search-icon far fa-search" />
    <input
      type="text"
      class="artist-header__search-input"
      placeholder="Searching..."
      @change="$emit('change', $event)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ArtistProfileHeaderSearch extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/artist/profile/artist-header-search';
</style>
