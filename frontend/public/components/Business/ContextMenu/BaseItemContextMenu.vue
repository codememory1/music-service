<template>
  <div class="context-menu__item" :class="{ disabled }" @click="$emit('click')">
    <span class="context-menu__item-title">{{ title }}</span>
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';

@Component
export default class BaseItemContextMenu extends Vue {
  @Prop({ required: true })
  private readonly title!: string;

  @Prop({ required: false, default: false })
  private readonly disabled!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/context-menu/base-item-context-menu.scss';
</style>
