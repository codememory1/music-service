<template>
  <li
    class="toolbar-mobile__item"
    role="presentation"
    :class="{ active: isActive }"
    @click="$emit('click', $event)"
  >
    <router-link v-if="typeof link !== 'string'" role="menuitem" :to="link">
      <svg-alias :alias="aliasIcon" />
      <span>{{ label }}</span>
    </router-link>
    <a v-else role="menuitem" :href="link">
      <svg-alias :alias="aliasIcon" />
      <span>{{ label }}</span>
    </a>
  </li>
</template>

<script>
export default {
  name: "BaseToolbarMobileItem",
  props: {
    /**
     * Icon alias from aliases.js
     */
    aliasIcon: {
      type: String,
      required: true
    },

    /**
     * Item label
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Link or router object
     */
    link: {
      type: [String, Object],
      required: true
    },

    /**
     * Is active item
     */
    isActive: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/toolbars/base-toolbar-mobile-item";
</style>
