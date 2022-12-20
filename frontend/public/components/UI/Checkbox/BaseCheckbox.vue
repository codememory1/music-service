<template>
  <input v-model="checked" type="checkbox" class="checkbox" :value="inputValue" />
</template>

<script lang="ts">
import { Component, Vue, VModel, Prop } from 'vue-property-decorator';

@Component
export default class BaseCheckbox extends Vue {
  @Prop({ required: false, default: false })
  private readonly inputValue!: string | number | boolean;

  @VModel({ required: false, default: false })
  private checked!: string | number | boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/checkbox/base-checkbox';
</style>
