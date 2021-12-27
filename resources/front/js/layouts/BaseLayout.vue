<template>
  <div class="base-layout">
    <!-- Block with alerts -->
    <block-alerts />

    <!-- Navigation -->
    <slot name="navigation" />

    <div ref="layoutContent" class="base-layout__content">
      <div class="content__scroll" ref="contentScroll">
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
@import "../../scss/variables";
@import "../../scss/mixins/scrollbarMixin";

.base-layout {
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

.navigation {
  min-width: 300px;
  border-right: 1px solid $light-bg;
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
