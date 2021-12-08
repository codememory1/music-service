<template>
  <div class="player-layout">
    <!-- Block with notifications -->
    <block-notifications />

    <!-- Player subdomain navigation -->
    <the-player-navigation />
    <div ref="playerLayoutContent" class="player-layout__content">
      <div class="content__scroll">
        <the-player-header />
        <router-view :position="contentPosition" />
      </div>
      <desktop-player />
    </div>
  </div>
</template>
<script>
import ThePlayerHeader from "../components/Headers/ThePlayerHeaderComponent";
import ThePlayerNavigation from "../components/Navigation/ThePlayerNavigationComponent";
import DesktopPlayer from "../components/Player/DesktopPlayerComponent";
import BlockNotifications from "../components/Blocks/BlockNotificationsComponent";

export default {
  name: "PlayerLayout",
  components: {
    ThePlayerHeader,
    ThePlayerNavigation,
    DesktopPlayer,
    BlockNotifications
  },

  data: () => ({
    contentPosition: {
      x: 0,
      y: 0
    }
  }),

  mounted() {
    const playerLayoutContentRect =
      this.$refs.playerLayoutContent.getBoundingClientRect();

    this.contentPosition.x = playerLayoutContentRect.x;
    this.contentPosition.y = playerLayoutContentRect.y;
  }
};
</script>
<style lang="scss" scoped>
@import "../../scss/variables";

.player-layout {
  display: grid;
  grid-template-columns: 300px 1fr;
  overflow: hidden;
  height: 100%;

  &__content {
    display: flex;
    flex-direction: column;
    width: 100%;
    position: relative;
    overflow: auto;
  }
}

.player__header {
  position: absolute;
  padding: 20px $gutter;
  z-index: 99;
}

.navigation {
  min-width: 300px;
  border-right: 1px solid $light-bg;
}

.player {
  margin-top: auto;
  border-top: 1px solid $light-bg;
}

.content__scroll {
  height: 100%;
  overflow: auto;
}

.main__content {
  margin-bottom: 30px;
}
</style>
