<template>
  <section class="inline-account-section" :class="{ disabled }" :aria-label="title">
	<!-- Header START -->
    <div class="inline-account-section__headers">
      <h3
        class="inline-account-section__title"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ title }}
      </h3>
      <p
        v-if="null !== subtitle"
        class="inline-account-section__subtitle"
        :class="{ 'skeleton-active': isLoading }"
      >
        {{ subtitle }}
      </p>
    </div>
	<!-- Header END -->

	<!-- Content START -->
    <div
      class="inline-account-section-content"
      :class="{ 'skeleton-active': isLoading }"
    >
      <slot />
    </div>
	<!-- Content END -->
  </section>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "InlineAccountSectionComponent",
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
    subtitle: {
      type: String,
      default: null,
      required: false
    },

    /**
     * @type {String}
     */
    iconAlias: {
      type: String,
      default: null,
      required: false
    },

    /**
     * @type {Boolean}
     */
    disabled: {
      type: Boolean,
      default: false,
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
@import "../../../scss/components/sections/inlineAccount";
</style>
