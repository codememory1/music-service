<template>
  <div class="select-loading">
    <i class="select-loading__icon far fa-spinner-third" />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectLoading extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/select/base-select-loading.scss';
</style>
