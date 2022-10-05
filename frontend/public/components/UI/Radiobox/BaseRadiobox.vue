<template>
  <input v-model="checked" type="radio" class="radiobox" :value="inputValue" />
</template>

<script lang="ts">
import { Component, Vue, Prop, VModel } from 'vue-property-decorator';

@Component
export default class BaseRadiobox extends Vue {
  @Prop({ required: false })
  private readonly inputValue!: string | number | boolean;

  @VModel({ required: false, default: null })
  private checked!: any;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/radiobox/base-radiobox';
</style>
