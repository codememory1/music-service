<template>
  <input v-model="isChecked" type="checkbox" class="checkbox" :class="{ error: isError }" />
</template>

<script lang="ts">
import { Component, Vue, Prop, VModel } from 'vue-property-decorator';

@Component
export default class BaseCheckbox extends Vue {
  @Prop({ required: false, default: false })
  private readonly isError!: boolean;

  @VModel({ required: false, default: false })
  private readonly isChecked!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/checkbox/base-checkbox.scss';
</style>
