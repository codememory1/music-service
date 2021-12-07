<template>
  <router-link class="navigation__item" active-class="active" :to="link">
    <li>
      <svg-alias :alias="iconAlias" />
      {{ label }}
    </li>
  </router-link>
</template>
<script>
export default {
  name: "NavigationItem",
  props: {
    /**
     * Alias icon from modules/Aliases
     *
     * @type {String}
     */
    iconAlias: {
      type: String,
      required: true
    },

    /**
     * Link name
     *
     * @type {String}
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Link that will be clicked on
     *
     * @type {String || Object}
     */
    link: {
      type: [String, Object],
      default: "",
      required: false
    },

    /**
     * The activity status of this item
     *
     * @type {Boolean}
     */
    isActive: {
      type: Boolean,
      default: false,
      required: false
    }
  }
};
</script>
