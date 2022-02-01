<template>
  <router-link
    class="navigation-category__item"
    role="presentation"
    active-class="active"
    :to="routerLink"
  >
    <li role="menuitem" :class="{ 'skeleton-active': skeletonActive }">
      <svg-alias :alias="aliasIcon" />
      {{ label }}
    </li>
  </router-link>
</template>

<script>
export default {
  name: "BaseNavigationCategoryItem",
  props: {
    /**
     * Alias icon from aliases.js
     */
    aliasIcon: {
      type: String,
      required: true
    },

    /**
     * Link label
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Link that will be clicked on
     */
    routerLink: {
      type: [Object],
      required: true
    },

    /**
     * The activity status of this item
     */
    isActive: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * Status skeleton
     */
    skeletonActive: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/navigations/base-navigation-category-item";
</style>
