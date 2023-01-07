<template>
  <div class="field-modal-form">
    <label v-if="null !== title" class="field-modal-form__title">{{ title }}</label>

    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class FieldModalForm extends Vue {
  @Prop({ required: false, default: null })
  private readonly title!: string | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/field/field-modal-form.scss';
</style>
