<template>
  <BaseContextMenu ref="contextMenu">
    <BaseGroupContextMenu>
      <BaseItemContextMenu :title="$t('context_menu.add_to_media_library')" />
      <BaseItemContextMenu :title="$t('context_menu.add_to_playlist')" />
      <BaseItemContextMenu :title="$t('context_menu.add_to_playlist_directory')" />
    </BaseGroupContextMenu>
    <BaseGroupContextMenu>
      <BaseItemContextMenu :title="$t('context_menu.to_the_artist')" />
      <BaseItemContextMenu :title="$t('context_menu.to_the_album')" />
      <BaseItemContextMenu :title="$t('context_menu.show_details')" />
    </BaseGroupContextMenu>
    <BaseGroupContextMenu>
      <BaseItemContextMenu :title="$t('context_menu.share')">
        <BaseNestedContextMenu>
          <BaseGroupContextMenu>
            <BaseItemContextMenu :title="$t('context_menu.copy_link')" />
            <BaseItemContextMenu :title="$t('context_menu.copy_widget_code')" />
          </BaseGroupContextMenu>
        </BaseNestedContextMenu>
      </BaseItemContextMenu>
    </BaseGroupContextMenu>
  </BaseContextMenu>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseContextMenu from '~/components/Business/ContextMenu/BaseContextMenu.vue';
import BaseNestedContextMenu from '~/components/Business/ContextMenu/BaseNestedContextMenu.vue';
import BaseGroupContextMenu from '~/components/Business/ContextMenu/BaseGroupContextMenu.vue';
import BaseItemContextMenu from '~/components/Business/ContextMenu/BaseItemContextMenu.vue';

@Component({
  components: {
    BaseContextMenu,
    BaseNestedContextMenu,
    BaseGroupContextMenu,
    BaseItemContextMenu
  }
})
export default class TrackContextMenu extends Vue {}
</script>
