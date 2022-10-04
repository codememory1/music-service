<template>
  <div class="select-top__selected-tag">
    <span class="select-top-selected-tag__text">{{ value }}</span>
    <i
      ref="closeSelectedTag"
      class="far fa-times select-top__btn-delete-tag"
      @click="$emit('close', $event)"
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class BaseSelectedTag extends Vue {
  @Prop({ required: true })
  value!: string | number;
}
</script>

<style lang="scss">
@import '@/assets/scss/ui/select/base-selected-tag';
</style>
