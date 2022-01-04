<template>
  <div class="base-layout">
    <!-- Block with alerts -->
    <block-alerts />

    <!-- Navigation -->
    <slot name="navigation" />

    <div ref="layoutContent" class="base-layout-content">
      <div class="content-scroll" role="scrollbar" ref="contentScroll">
        <!-- Header -->
        <slot name="header" />

        <!-- content of a specific route -->
        <router-view />
      </div>

      <!-- Slot after div.content__scroll -->
      <slot name="afterContentScroll" />
    </div>
  </div>
</template>
<script>
import BlockAlerts from "../components/Blocks/BlockAlertsComponent";

export default {
  name: "BaseLayout",
  components: {
    BlockAlerts
  },

  computed: {
    /**
     * Ref layoutContent
     *
     * @returns {HTMLDivElement}
     */
    layoutContent() {
      return this.$refs.layoutContent;
    },

    /**
     * Ref contentScroll
     *
     * @returns {HTMLDivElement}
     */
    contentScroll() {
      return this.$refs.contentScroll;
    }
  },

  async created() {
    await this.$store.dispatch("translation/receiveTranslations");
  },

  mounted() {
    document.documentElement.setAttribute(
      "lang",
      this.$store.getters["translation/lang"]
    );
  }
};
</script>
<style lang="scss">
@import "../../scss/layouts/baseLayout";
</style>
