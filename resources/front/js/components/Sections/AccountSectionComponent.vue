<template>
  <section class="account-section" :aria-label="title">
    <!-- Section top START -->
    <div class="account-section-top">
      <svg-alias
        v-if="null !== iconAlias"
        :alias="iconAlias"
        :class="{ 'skeleton-active': isLoading }"
      />
      <h3
        class="account-section__title"
        :class="{ 'skeleton-active': isLoading }"
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
  name: "AccountSectionComponent",
  props: {
    /**
     * @type {String}
     */
    title: {
      type: String,
      required: true
    },

    /**
     * @type {String}
     */
    iconAlias: {
      type: String,
      default: null,
      required: false
    }
  },

  computed: {
    ...mapGetters({
      isLoading: "loading/isLoading"
    })
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/components/sections/account";
</style>
