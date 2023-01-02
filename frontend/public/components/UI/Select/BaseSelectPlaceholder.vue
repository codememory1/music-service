<template>
  <span class="select__placeholder">{{ placeholder }}</span>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectPlaceholder extends Vue {
  @Prop({ required: true })
  private readonly placeholder!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-placeholder.scss';
</style>
