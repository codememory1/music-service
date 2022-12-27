<template>
  <div class="alert-list">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseAlertList extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/list/base-alert-list.scss';
</style>
