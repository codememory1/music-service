<template>
  <li class="context-menu__item" @click="$emit('click', item)">
    {{ item.label }} <i v-if="undefined !== item.context_menu" class="far fa-chevron-right" />
  </li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { ContextMenuItemType } from '~/types/ContextMenuItemType';

@Component
export default class BaseItemContextMenu extends Vue {
  @Prop({ required: true })
  private readonly item!: ContextMenuItemType;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/context-menu/base-item-context-menu';
</style>
