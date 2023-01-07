<template>
  <div class="form-input-wrapper">
    <input
      :type="type"
      class="form__input"
      :class="{ error: isError }"
      :placeholder="$t(placeholder)"
      :name="name"
      @input="$emit('input', $event)"
    />
    <p v-if="undefined !== description" class="form-input__description">{{ description }}</p>
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

  @Prop({ required: false, default: undefined })
  private readonly name!: string | undefined;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/input/base-input.scss';
</style>
