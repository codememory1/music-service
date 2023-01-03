<template>
  <input v-if="!asRadio" v-model="isChecked" type="checkbox" class="switchbox" :class="{ error }" />
  <input v-else v-model="isChecked" type="radio" class="switchbox" :class="{ error }" />
</template>

<script lang="ts">
import { Component, Prop, VModel, Vue } from 'vue-property-decorator';
@Component
export default class BaseSwitchbox extends Vue {
  @Prop({ required: false, default: false })
  private readonly error!: boolean;

  @Prop({ required: false, default: false })
  private readonly asRadio!: boolean;

  @VModel({ required: false, default: false })
  private readonly isChecked!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/switchbox/base-switchbox.scss';
</style>
