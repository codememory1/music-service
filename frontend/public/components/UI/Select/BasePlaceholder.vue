<template>
  <span class="select-top__placeholder">
    {{ placeholder }}
  </span>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BasePlaceholder extends Vue {
  @Prop({ required: true })
  private readonly placeholder!: string;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/select/base-placeholder';
</style>
