<template>
  <div class="select-list-selected-tags">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectListSelectedTags extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-selected-tag-list.scss';
</style>
