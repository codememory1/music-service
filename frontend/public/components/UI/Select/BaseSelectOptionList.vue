<template>
  <div class="select-option-list">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectOptionList extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-option-list.scss';
</style>
