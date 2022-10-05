<template>
  <input v-model="checked" :type="type" class="switchbox" :value="inputValue" />
</template>

<script lang="ts">
import { Component, Vue, Prop, VModel } from 'vue-property-decorator';

@Component
export default class BaseSwitchbox extends Vue {
  @Prop({ required: false, default: 'checkbox' })
  private readonly type!: string;

  @Prop({ required: false })
  private readonly inputValue!: string | number | boolean;

  @VModel({ required: false, default: false })
  private checked!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/switchbox/base-switchbox.scss';
</style>
