<template>
  <div class="block-form-elements">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BlockFormElements extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/block/block-form-elements.scss';
</style>
