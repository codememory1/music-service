<template>
  <div class="form-input-wrapper">
    <textarea
      class="form__input textarea"
      :class="{ error: isError }"
      :placeholder="$t(placeholder)"
      @input="$emit('input', $event)"
    />
    <p v-if="undefined !== description" class="form-input__description">{{ description }}</p>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseTextarea extends Vue {
  @Prop({ required: false, default: '' })
  private readonly placeholder!: string;

  @Prop({ required: false, default: undefined })
  private readonly description!: string | undefined;

  @Prop({ required: false, default: false })
  private readonly isError!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/input/base-textarea.scss';
</style>
