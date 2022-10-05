<template>
  <input v-model="checked" type="checkbox" class="checkbox" />
</template>

<script lang="ts">
import { Component, Vue, VModel } from 'vue-property-decorator';

@Component
export default class BaseCheckbox extends Vue {
  @VModel({ required: false, default: false })
  private checked!: string | number | boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/checkbox/base-checkbox';
</style>
