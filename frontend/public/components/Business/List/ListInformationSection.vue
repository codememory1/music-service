<template>
  <div class="list-information-section">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class ListInformationSection extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/list/list-information-section.scss';
</style>
