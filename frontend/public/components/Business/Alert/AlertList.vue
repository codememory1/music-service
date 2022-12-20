<template>
  <div class="alert-list">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class AlertList extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/alert/alert-list';
</style>
