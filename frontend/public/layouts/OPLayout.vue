<template>
  <main class="op-layout">
    <OPNavigation>
      <template #categories>
        <OPNavigationCategory>
          <OPNavigationItem fa-icon="far fa-home" title="Home" to="/" />
          <OPNavigationItem fa-icon="far fa-search" title="Search" to="/" />
          <OPNavigationItem fa-icon="far fa-history" title="History" to="/" />
        </OPNavigationCategory>
        <OPNavigationCategory title="Your Library">
          <OPNavigationItem fa-icon="far fa-user" title="Artist" to="/" />
          <OPNavigationItem fa-icon="far fa-album" title="Album" to="/" />
          <OPNavigationItem fa-icon="far fa-heart" title="Favorite songs " to="/" />
          <OPNavigationItem fa-icon="far fa-list-music" title="Playlists" to="/" />
        </OPNavigationCategory>
        <OPNavigationCategory title="Playlist">
          <OPNavigationItem fa-icon="far fa-list-music" title="First playlist" to="/" />
          <OPNavigationItem fa-icon="far fa-list-music" title="Second playlist" to="/" />
          <OPNavigationItem fa-icon="far fa-list-music" title="Third playlist" to="/" />
          <OPNavigationItem fa-icon="far fa-list-music" title="Fourth playlist" to="/" />
        </OPNavigationCategory>
      </template>
    </OPNavigation>

    <div class="op-content-wrapper">
      <div class="op-header" :class="{ active: headerIsActive }">
        <PortalTarget name="header" />

        <OPHeaderUserInfo />
      </div>

      <div ref="content" class="op-content-scroll" @scroll="scrollContent">
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
export default class OPLayout extends Vue {
  private headerIsActive: boolean = false;

  private scrollContent(event: Event): void {
    this.headerIsActive = (event.target as HTMLElement).scrollTop >= 40;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/layout/base-op-layout.scss';
</style>
