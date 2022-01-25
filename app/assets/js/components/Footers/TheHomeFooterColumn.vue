<template>
  <div class="footer-column">
    <span class="footer-column__name">{{ label }}</span>

    <div v-if="!customContent" class="footer-column-items">
      <slot />
    </div>

    <slot v-else />
  </div>
</template>

<script>
export default {
  name: "TheHomeFooterColumn",
  props: {
    /**
     * Column label
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Custom content slot outside items
     */
    customContent: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/footers/the-home-footer-column";
</style>
