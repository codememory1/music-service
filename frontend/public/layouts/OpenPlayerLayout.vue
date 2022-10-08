<template>
  <main class="open-player-layout">
    <PlayerNavigation>
      <template #categories>
        <PlayerNavigationCategory>
          <PlayerNavigationItem fa-icon="far fa-home" title="Home" to="/" />
          <PlayerNavigationItem fa-icon="far fa-search" title="Search" to="/" />
          <PlayerNavigationItem fa-icon="far fa-history" title="History" to="/" />
        </PlayerNavigationCategory>
        <PlayerNavigationCategory title="Your Library">
          <PlayerNavigationItem fa-icon="far fa-user" title="Artist" to="/" />
          <PlayerNavigationItem fa-icon="far fa-album" title="Album" to="/" />
          <PlayerNavigationItem fa-icon="far fa-heart" title="Favorite songs " to="/" />
          <PlayerNavigationItem fa-icon="far fa-list-music" title="Playlists" to="/" />
        </PlayerNavigationCategory>
        <PlayerNavigationCategory title="Playlist">
          <PlayerNavigationItem fa-icon="far fa-list-music" title="First playlist" to="/" />
          <PlayerNavigationItem fa-icon="far fa-list-music" title="Second playlist" to="/" />
          <PlayerNavigationItem fa-icon="far fa-list-music" title="Third playlist" to="/" />
          <PlayerNavigationItem fa-icon="far fa-list-music" title="Fourth playlist" to="/" />
        </PlayerNavigationCategory>
      </template>
    </PlayerNavigation>

    <div class="content-wrapper">
      <div class="open-player-header">
        <slot name="header" />

        <OpenPlayerHeaderUserInfo />
      </div>

      <div class="content-scroll">
        <slot />
      </div>

      <DesktopPlayer />
    </div>
  </main>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import PlayerNavigation from '~/components/Business/Navigation/PlayerNavigation/PlayerNavigation.vue';
import PlayerNavigationCategory from '~/components/Business/Navigation/PlayerNavigation/PlayerNavigationCategory.vue';
import PlayerNavigationItem from '~/components/Business/Navigation/PlayerNavigation/PlayerNavigationItem.vue';
import OpenPlayerHeaderUserInfo from '~/components/Business/Header/OpenPlayerHeaderUserInfo.vue';
import DesktopPlayer from '~/components/Business/Player/DesktopPlayer.vue';

@Component({
  components: {
    PlayerNavigation,
    PlayerNavigationCategory,
    PlayerNavigationItem,
    OpenPlayerHeaderUserInfo,
    DesktopPlayer
  }
})
export default class OpenPlayerLayout extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/layout/open-player-layout';
</style>
