<template>
  <div class="context-menu-group">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseGroupContextMenu extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/context-menu/base-group-context-menu.scss';
</style>
