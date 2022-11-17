<template>
  <li
    class="context-menu__item"
    :class="{ disabled: item.disabled, border: item.border }"
    @click="clickByItem"
  >
    {{ item.label }} <i v-if="undefined !== item.context_menu" class="far fa-chevron-right" />
  </li>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { ContextMenuItemType } from '~/types/ContextMenuItemType';
import { getContextMenuModule } from '~/store';

@Component
export default class BaseItemContextMenu extends Vue {
  @Prop({ required: true })
  private readonly item!: ContextMenuItemType;

  private clickByItem(): void {
    if (undefined === this.item.context_menu) {
      this.$emit('clickByItem', this.item);
    } else {
      getContextMenuModule(this.$store).setContextMenu(this.item.context_menu);
      getContextMenuModule(this.$store).setIsShowBackwardButton(true);

      this.$emit('next', this.item);
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/context-menu/base-item-context-menu';
</style>
