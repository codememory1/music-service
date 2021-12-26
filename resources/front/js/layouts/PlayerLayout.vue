<template>
  <div class="player-layout">
    <!-- Block with alerts -->
    <block-alerts />

    <!-- Player subdomain navigation -->
    <the-player-navigation />

    <div ref="playerLayoutContent" class="player-layout__content">
      <div class="content__scroll" ref="contentScroll">
        <!-- Header -->
        <the-player-header />

        <!-- View -->
        <router-view />
      </div>

      <!-- Desktop player -->
      <desktop-player />
    </div>
  </div>
</template>
<script>
import { mapMutations } from "vuex";
import ThePlayerHeader from "../components/Headers/ThePlayerHeaderComponent";
import ThePlayerNavigation from "../components/Navigation/ThePlayerNavigationComponent";
import DesktopPlayer from "../components/Player/DesktopPlayerComponent";
import BlockAlerts from "../components/Blocks/BlockAlertsComponent";

export default {
  name: "PlayerLayout",
  components: {
    ThePlayerHeader,
    ThePlayerNavigation,
    DesktopPlayer,
    BlockAlerts
  },

  mounted() {
    const playerLayoutContentRect =
      this.$refs.playerLayoutContent.getBoundingClientRect();

    this.setContentX(playerLayoutContentRect.x);
    this.setContentY(playerLayoutContentRect.y);

    this.$refs.contentScroll.addEventListener("scroll", this.setLayoutScroll);
    window.addEventListener("contextmenu", this.contextmenu);
  },

  methods: {
    ...mapMutations({
      setContentX: "layoutScroll/setContentX",
      setContentY: "layoutScroll/setContentY"
    }),

    setLayoutScroll() {
      this.$store.commit("layoutScroll/setScroll", true);
    },

    /**
     * Handling opening a context menu
     *
     * @param e
     * @returns {boolean}
     */
    contextmenu(e) {
      e.preventDefault();

      return false;
    }
  },

  beforeDestroy() {
    this.$refs.contentScroll.removeEventListener(
      "scroll",
      this.setLayoutScroll
    );
    window.removeEventListener("contextmenu", this.contextmenu);
  }
};
</script>
<style lang="scss" scoped>
@import "../../scss/variables";
@import "../../scss/mixins/scrollbarMixin";

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
    overflow: hidden;
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

  @include scrollbarMixin;
}

.main__content {
  margin-bottom: 30px;
}
</style>
