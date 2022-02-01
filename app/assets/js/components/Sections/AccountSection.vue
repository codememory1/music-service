<template>
  <section class="account-section" :aria-label="title">
    <!-- Section top START -->
    <div class="account-section-top">
      <svg-alias
        v-if="null !== aliasIcon"
        :alias="aliasIcon"
        :class="{ 'skeleton-active': !isCameTranslation }"
      />
      <h3
        class="account-section__title"
        :class="{ 'skeleton-active': !isCameTranslation }"
      >
        {{ title }}
      </h3>
    </div>
    <!-- Section top END -->

    <slot />
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "AccountSection",
  props: {
    /**
     * Section title
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Alias icon from Aliases.js
     */
    aliasIcon: {
      type: String,
      default: null,
      required: false
    }
  },

  computed: {
    ...mapGetters({
      isCameTranslation: "requestStatuses/isCameTranslation"
    })
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/sections/account-section";
</style>
