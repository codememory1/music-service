<template>
  <transition name="fade">
    <div class="context-menu" role="menu">
      <div v-if="isShowBackwardButton" class="context-menu-top">
        <BaseButton class="context-menu__backward-btn" @click="backward">
          <i class="far fa-chevron-left" /> {{ $t('common.back') }}
        </BaseButton>
      </div>

      <div class="context-menu-content">
        <ul class="context-menu-items">
          <BaseItemContextMenu
            v-for="item in activeContextMenu.items"
            :key="item.id"
            :item="item"
          />
        </ul>
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseItemContextMenu from '~/components/Business/ContextMenu/BaseItemContextMenu.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import { ContextMenuType } from '~/types/ContextMenuType';
import { getContextMenuModule } from '~/store';

type FormattedContextMenu = {
  [key: string]: ContextMenuType;
};

@Component({
  components: {
    BaseItemContextMenu,
    BaseButton
  }
})
export default class BaseContextMenu extends Vue {
  @Prop({ required: true })
  private readonly contextMenu!: ContextMenuType;

  private formattedContextMenu: FormattedContextMenu = {};

  private created(): void {
    getContextMenuModule(this.$store).setContextMenu(this.contextMenu);

    this.contextMenuFormatting(this.contextMenu);
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

  private get activeContextMenu(): ContextMenuType {
    return getContextMenuModule(this.$store).contextMenu as ContextMenuType;
  }

  private get isShowBackwardButton(): boolean {
    return getContextMenuModule(this.$store).isShowBackwardButton;
  }

  private backward(): void {
    let backwardContextMenu: ContextMenuType | undefined;

    if (this.activeContextMenu!.id in this.formattedContextMenu) {
      backwardContextMenu = this.formattedContextMenu[this.activeContextMenu.id];

      getContextMenuModule(this.$store).setContextMenu(backwardContextMenu!);
      getContextMenuModule(this.$store).setIsShowBackwardButton(
        backwardContextMenu!.id in this.formattedContextMenu
      );
    }

    this.$emit('backward', this.activeContextMenu, backwardContextMenu);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/context-menu/base-context-menu';
</style>
