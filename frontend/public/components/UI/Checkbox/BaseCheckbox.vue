<template>
  <input type="checkbox" class="checkbox" />
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseCheckbox extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/ui/checkbox/base-checkbox';
</style>
