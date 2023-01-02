<template>
  <div class="select__option" :class="{ selected: isActive }" @click="$emit('click', $event)">
    <span class="select__option-title">{{ title }}</span>
    <i v-if="isActive" class="select__option-check far fa-check" />
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectOption extends Vue {
  @Prop({ required: false, default: false })
  private readonly isActive!: boolean;

  @Prop({ required: true })
  private readonly title!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-option.scss';
</style>
