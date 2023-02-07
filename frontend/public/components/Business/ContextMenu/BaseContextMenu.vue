<template>
  <div
    ref="contextMenu"
    class="context-menu"
    :class="{ active: contextMenuService.isOpen() }"
    :style="contextMenuService.getStyles()"
  >
    <div class="context-menu-groups">
      <slot />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import ContextMenuService from '~/services/ui/context-menu/context-menu-service';
import clickOut from '~/utils/click-out';

@Component
export default class BaseContextMenu extends Vue {
  public contextMenuService!: ContextMenuService;

  public created(): void {
    this.contextMenuService = new ContextMenuService(this);
  }

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
