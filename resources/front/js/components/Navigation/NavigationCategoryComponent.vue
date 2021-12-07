<template>
  <div class="navigation__category">
    <span v-if="undefined !== title" class="navigation__category--name">{{
      title
    }}</span>
    <ul class="navigation__items">
      <slot name="items" />
    </ul>
  </div>
</template>
<script>
export default {
  name: "NavigationCategory",
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
