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
    <slot name="drop-down" />
  </li>
</template>
<script>
export default {
  name: "DropDownItemComponent",
  props: {
    /**
     * Link when clicking on which will be redirected
     *
     * @type {String}
     */
    link: {
      type: String,
      default: null,
      required: false
    },

    /**
     * Whether to make the current item multi
     *
     * @type {Boolean}
     */
    isMultiple: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * Prevent click on this item
     *
     * @type {Boolean}
     */
    isDisabled: {
      type: Boolean,
      default: false,
      required: false
    },

    /**
     * The name of the item to be displayed
     *
     * @type {String}
     */
    label: {
      type: String,
      required: true
    }
  }
};
</script>
