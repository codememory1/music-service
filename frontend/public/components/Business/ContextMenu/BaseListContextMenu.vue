<template>
  <transition-group name="context-menu" tag="ul" class="context-menu-items">
    <BaseItemContextMenu v-for="item in items" :key="item.id" :item="item" @click="multipleClick" />
  </transition-group>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { ContextMenuItemType } from '~/types/ContextMenuItemType';
import BaseItemContextMenu from '~/components/Business/ContextMenu/BaseItemContextMenu.vue';
import { getContextMenuModule } from '~/store';

@Component({
  components: {
    BaseItemContextMenu
  }
})
export default class BaseListContextMenu extends Vue {
  @Prop({ required: true })
  private readonly items!: Array<ContextMenuItemType>;

  private multipleClick(item: ContextMenuItemType): void {
    getContextMenuModule(this.$store).setActiveContextMenu(item.context_menu!, 'right');
    getContextMenuModule(this.$store).setIsShowBackwardButton(true);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/context-menu/base-list-context-menu';
</style>
