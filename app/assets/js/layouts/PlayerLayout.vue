<template>
  <base-layout ref="layout">
    <!-- Player subdomain navigation -->
    <template v-slot:navigation>
      <the-player-navigation />
    </template>

    <!-- Header -->
    <template v-slot:header>
      <the-player-header />
    </template>

    <!-- Desktop player -->
    <template v-slot:afterContentScroll>
      <base-desktop-player />
    </template>
  </base-layout>
</template>
<script>
import { mapMutations } from "vuex";
import BaseLayout from "./BaseLayout";
import ThePlayerHeader from "../components/Headers/ThePlayerHeader";
import ThePlayerNavigation from "../components/Navigations/ThePlayerNavigation";
import BaseDesktopPlayer from "../components/Players/BaseDesktopPlayer";

export default {
  name: "PlayerLayout",
  components: {
    BaseLayout,
    ThePlayerHeader,
    ThePlayerNavigation,
    BaseDesktopPlayer
  },

  computed: {
    /**
     * @returns {HTMLDivElement}
     */
    content() {
      return this.$refs.layout.layoutContent;
    },

    /**
     * @returns {HTMLDivElement}
     */
    contentScroll() {
      return this.$refs.layout.contentScroll;
    }
  },

  mounted() {
    const playerLayoutContentRect = this.content.getBoundingClientRect();

    this.setContentX(playerLayoutContentRect.x);
    this.setContentY(playerLayoutContentRect.y);

    this.contentScroll.addEventListener("scroll", this.setLayoutScroll);
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
    this.contentScroll.removeEventListener("scroll", this.setLayoutScroll);
    window.removeEventListener("contextmenu", this.contextmenu);
  }
};
</script>
<style lang="scss" scoped>
.player {
  margin-top: auto;
}
</style>
