<template>
  <div class="form-input-wrapper">
    <input
      :type="type"
      class="form__input"
      :class="{ error: isError }"
      :placeholder="$t(placeholder)"
      @input="$emit('input', $event)"
    />
    <p v-if="undefined !== description" class="form-input__description">{{ $t(description) }}</p>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseInput extends Vue {
  @Prop({ required: false, default: 'text' })
  private readonly type!: string;

  @Prop({ required: false, default: '' })
  private readonly placeholder!: string;

  @Prop({ required: false, default: undefined })
  private readonly description!: string | undefined;

  @Prop({ required: false, default: false })
  private readonly isError!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/input/base-input.scss';
</style>
