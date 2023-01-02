<template>
  <div class="select-box-current" @click="$emit('click', $event)">
    <slot />

    <div class="select-box-current__chevron" :class="{ active: isActive }">
      <i class="far fa-chevron-down" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseSelectBoxCurrent extends Vue {
  @Prop({ required: false, default: false })
  private readonly isActive!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/select/base-select-box-current.scss';
</style>
