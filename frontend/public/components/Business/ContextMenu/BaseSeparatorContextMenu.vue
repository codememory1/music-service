<template>
  <div class="context-menu__separator"></div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSeparatorContextMenu extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/context-menu/base-separator-context-menu';
</style>
