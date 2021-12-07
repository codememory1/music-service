<template>
  <router-link v-if="isRouterLink" :to="link" class="base-button">
    <slot />
  </router-link>
  <a v-else :href="link" class="button">
    <slot />
  </a>
</template>
<script>
export default {
  name: "BaseLinkButton",
  props: {
    /**
     * Link or data router
     *
     * @type {String}
     */
    link: {
      type: [String, Object],
      required: true
    },

    /**
     * Whether to use router-link
     *
     * @type {Boolean}
     */
    isRouterLink: {
      type: Boolean,
      default: false,
      required: false
    }
  }
};
</script>
