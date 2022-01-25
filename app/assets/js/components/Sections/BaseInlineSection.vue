<template>
  <section class="inline-section" :class="{ isDisabled }" :aria-label="title">
    <!-- Header START -->
    <div class="inline-section__headers">
      <h3
        class="inline-section__title"
        :class="{ 'skeleton-active': !isCameTranslation }"
      >
        {{ title }}
      </h3>
      <p
        v-if="null !== subtitle"
        class="inline-section__subtitle"
        :class="{ 'skeleton-active': !isCameTranslation }"
      >
        {{ subtitle }}
      </p>
    </div>
    <!-- Header END -->

    <!-- Content START -->
    <div
      class="inline-section-content"
      :class="{ 'skeleton-active': !isCameContent }"
    >
      <slot />
    </div>
    <!-- Content END -->
  </section>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "BaseInlineSection",
  props: {
    /**
     * Section title
     */
    title: {
      type: String,
      required: true
    },

    /**
     * Subtitle section
     */
    subtitle: {
      type: String,
      default: null
    },

    /**
     * Is disabled section
     */
    isDisabled: {
      type: Boolean,
      default: false
    },

    /**
     * Content came
     */
    isCameContent: {
      type: Boolean,
      default: true
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
@import "../../../scss/components/sections/base-inline-section";
</style>
