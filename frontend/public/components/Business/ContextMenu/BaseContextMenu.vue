<template>
  <div class="context-menu" role="menu">
    <div v-if="isShowBackwardButton" class="context-menu-top">
      <BaseButton class="context-menu__backward-btn" @click="backward">
        <i class="far fa-long-arrow-alt-left" /> Backward
      </BaseButton>
    </div>

    <div class="context-menu-content">
      <BaseListContextMenu :items="activeContextMenu.items" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseListContextMenu from '~/components/Business/ContextMenu/BaseListContextMenu.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { ContextMenuType } from '~/types/ContextMenuType';
import { getContextMenuModule } from '~/store';

type FormattedContextMenu = {
  [key: string]: ContextMenuType;
};

@Component({
  components: {
    BaseListContextMenu,
    BaseButton
  }
})
export default class BaseContextMenu extends Vue {
  @Prop({ required: true })
  private readonly contextMenu!: ContextMenuType;

  private formattedContextMenu: FormattedContextMenu = {};

  private created(): void {
    getContextMenuModule(this.$store).setActiveContextMenu(this.contextMenu, 'none');

    this.contextMenuFormatting(this.contextMenu);
  }

  private get activeContextMenu(): ContextMenuType {
    return getContextMenuModule(this.$store).activeContextMenu as ContextMenuType;
  }

  private get isShowBackwardButton(): boolean {
    return getContextMenuModule(this.$store).isShowBackwardButton;
  }

  private get transition(): string {
    return getContextMenuModule(this.$store).transition;
  }

  private contextMenuFormatting(
    currentContextMenu: ContextMenuType,
    prevContextMenu?: ContextMenuType
  ): void {
    currentContextMenu.items.forEach((contextMenu) => {
      if (undefined !== prevContextMenu) {
        this.formattedContextMenu[currentContextMenu.id] = prevContextMenu;
      }

      if (undefined !== contextMenu.context_menu) {
        this.contextMenuFormatting(contextMenu.context_menu, currentContextMenu);
      }
    });
  }

  private backward(): void {
    const activeContextMenu = getContextMenuModule(this.$store)
      .activeContextMenu as ContextMenuType;
    let backwardContextMenu: ContextMenuType | undefined;

    if (activeContextMenu!.id in this.formattedContextMenu) {
      backwardContextMenu = this.formattedContextMenu[activeContextMenu.id];

      getContextMenuModule(this.$store).setActiveContextMenu(backwardContextMenu, 'left');
      getContextMenuModule(this.$store).setIsShowBackwardButton(
        backwardContextMenu.id in this.formattedContextMenu
      );
    }

    this.$emit('backward', activeContextMenu, backwardContextMenu);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/context-menu/base-context-menu';
</style>
