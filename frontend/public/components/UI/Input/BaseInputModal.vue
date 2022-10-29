<template>
  <div class="modal-field">
    <slot name="up" />

    <input
      class="modal-field__input"
      :type="inputType"
      :placeholder="placeholder"
      @input="$emit('input', $event)"
    />

    <slot name="down" />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseInputModal extends Vue {
  @Prop({ required: false, default: 'text' })
  private readonly inputType!: string;

  @Prop({ required: true })
  private readonly placeholder!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/input/base-input-modal';
</style>
