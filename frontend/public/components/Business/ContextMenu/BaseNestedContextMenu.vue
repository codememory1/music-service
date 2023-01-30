<template>
  <div class="context-menu">
    <div class="context-menu-groups">
      <slot />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseNestedContextMenu extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/context-menu/base-context-menu.scss';
</style>
