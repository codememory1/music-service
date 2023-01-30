<template>
  <transition name="fade">
    <div
      v-show="contextMenuService.isOpen()"
      ref="contextMenu"
      class="context-menu"
      :style="contextMenuService.getStyles()"
    >
      <div class="context-menu-groups">
        <slot />
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import ContextMenuService from '~/services/ui/context-menu/context-menu-service';
import clickOut from '~/utils/click-out';

@Component
export default class BaseContextMenu extends Vue {
  public readonly contextMenuService: ContextMenuService = new ContextMenuService(this);

  public mounted(): void {
    this.clickOutContextMenu();
  }

  public beforeDestroy(): void {
    document.removeEventListener('click', this.clickOutContextMenu);
  }

  private clickOutContextMenu(): void {
    clickOut(this.$refs.contextMenu as HTMLElement, (is) => {
      if (is) {
        this.contextMenuService.close();
      }
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/context-menu/base-context-menu.scss';
</style>
