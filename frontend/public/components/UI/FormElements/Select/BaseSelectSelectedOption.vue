<template>
  <div class="select__selected-option">
    <span class="select__selected-option-title">{{ title }}</span>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectSelectedOption extends Vue {
  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/select/base-select-selected-option.scss';
</style>
