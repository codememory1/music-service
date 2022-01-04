<template>
  <router-link
    class="navigation__item"
    active-class="active"
    :to="link"
    role="presentation"
  >
    <li :class="{ 'skeleton-active': isLoading }" role="menuitem">
      <svg-alias :alias="iconAlias" />
      {{ label }}
    </li>
  </router-link>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  name: "NavigationItemComponent",
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
  },

  computed: {
    ...mapGetters({
      isLoading: "loading/isLoading"
    })
  }
};
</script>
