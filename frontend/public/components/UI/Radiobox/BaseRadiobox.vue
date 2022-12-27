<template>
  <input v-model="isChecked" type="radio" class="radiobox" :class="{ error }" />
</template>

<script lang="ts">
import { Component, Vue, Prop, VModel } from 'vue-property-decorator';

@Component
export default class BaseRadiobox extends Vue {
  @Prop({ required: false, default: false })
  private readonly error!: boolean;

  @VModel({ required: false, default: false })
  private readonly isChecked!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/radiobox/base-radiobox.scss';
</style>
