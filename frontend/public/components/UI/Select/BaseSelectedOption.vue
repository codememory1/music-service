<template>
  <span class="select-top__selected-item">{{ value }}</span>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseSelectedOption extends Vue {
  @Prop({ required: true })
  value!: string | number | null;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/select/base-selected-option';
</style>
