<template>
  <div class="navigation-category">
    <span v-if="undefined !== title" class="navigation-category__name">
      {{ title }}
    </span>

    <!-- Category items START -->
    <ul class="navigation-category-items" role="menubar">
      <slot />
    </ul>
    <!-- Category items END -->
  </div>
</template>

<script>
export default {
  name: "BaseNavigationCategory",
  props: {
    /**
     * Category title
     */
    title: {
      type: String,
      required: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/navigations/base-navigation-category";
</style>
