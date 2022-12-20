<template>
  <a class="artist-link">
    <slot />
  </a>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ArtistLink extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/link/artist-link';
</style>
