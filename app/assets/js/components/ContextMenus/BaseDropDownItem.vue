<template>
  <li
    class="drop-down__item"
    :class="{
      multiple: isMultiple,
      disabled: isDisabled
    }"
    @click="$emit('click')"
  >
    <a v-if="link !== null" :href="link">
      {{ label }}
    </a>
    <template v-else>{{ label }}</template>

    <slot />
  </li>
</template>

<script>
export default {
  name: "BaseDropDownItem",
  props: {
    /**
     * The name of the item to be displayed
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Link when clicking on which will be redirected
     */
    link: {
      type: String,
      default: null
    },

    /**
     * Whether to make the current item multi
     */
    isMultiple: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * Prevent click on this item
     */
    isDisabled: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/context-menus/base-drop-down-item";
</style>
