<template>
  <span class="section__empty">
    <slot />
  </span>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class EmptyContentSection extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/section/parts/empty-content-section.scss';
</style>
