<template>
  <input v-model="checked" type="radio" class="radiobox" />
</template>

<script lang="ts">
import { Component, Vue, VModel } from 'vue-property-decorator';

@Component
export default class BaseRadiobox extends Vue {
  @VModel({ required: false, default: null })
  private checked!: any;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/radiobox/base-radiobox';
</style>
