<template>
  <div class="navigation-category">
    <span v-if="undefined !== title" class="navigation-category__name">{{
      title
    }}</span>
    <ul class="navigation_items" role="menubar">
      <slot name="items" />
    </ul>
  </div>
</template>
<script>
export default {
  name: "NavigationCategoryComponent",
  props: {
    /**
     * name of category
     *
     * @type {String}
     */
    title: {
      type: String,
      required: false
    }
  }
};
</script>
