<template>
  <div class="field-modal-form">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class FieldModalForm extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/field/field-modal-form.scss';
</style>
