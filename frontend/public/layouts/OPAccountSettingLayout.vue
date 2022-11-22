<template>
  <main class="op-layout">
    <OPNavigation>
      <template #categories>
        <OPNavigationCategory>
          <OPNavigationItem fa-icon="far fa-cog" title="General settings" to="/" />
          <OPNavigationItem fa-icon="far fa-shield-check" title="Security & Login" to="/" />
          <OPNavigationItem fa-icon="far fa-signal-stream" title="Media & Stream" to="/" />
          <OPNavigationItem fa-icon="far fa-globe" title="Language & Region" to="/" />
          <OPNavigationItem fa-icon="far fa-bell" title="Notifications" to="/" />
        </OPNavigationCategory>
      </template>
    </OPNavigation>

    <div class="op-content-wrapper">
      <div class="op-header" :class="{ active: headerIsActive }">
        <div class="op-header__page-title">
          <PortalTarget name="page-title" />
        </div>

        <OPHeaderUserInfo />
      </div>

      <div ref="content" class="op-content-scroll account-setting-content" @scroll="scrollContent">
        <Nuxt />
      </div>

      <DesktopPlayer />
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import OPNavigation from '~/components/Business/Navigation/OPNavigation/OPNavigation.vue';
import OPNavigationCategory from '~/components/Business/Navigation/OPNavigation/OPNavigationCategory.vue';
import OPNavigationItem from '~/components/Business/Navigation/OPNavigation/OPNavigationItem.vue';
import OPHeaderUserInfo from '~/components/Business/Header/OPHeaderUserInfo.vue';
import DesktopPlayer from '~/components/Business/Player/DesktopPlayer.vue';

@Component({
  components: {
    OPNavigation,
    OPNavigationCategory,
    OPNavigationItem,
    OPHeaderUserInfo,
    DesktopPlayer
  }
})
export default class OPAccountSettingLayout extends Vue {
  private headerIsActive: boolean = false;

  private scrollContent(event: Event): void {
    this.headerIsActive = (event.target as HTMLElement).scrollTop >= 40;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/layout/base-op-layout.scss';

.account-setting-content {

}
</style>
