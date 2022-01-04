<template>
  <li
    role="option"
    class="option"
    :class="{
      active: isActive,
      disabled: isDisabled
    }"
    :aria-disabled="isDisabled"
    :aria-label="label"
    @click="$emit('click', $event)"
  >
    {{ label }}
  </li>
</template>

<script>
export default {
  name: "BaseSelectOptionComponent",
  props: {
    /**
     * @type {Boolean}
     */
    isActive: {
      type: Boolean,
      required: true
    },

    /**
     * @type {Boolean}
     */
    isDisabled: {
      type: Boolean,
      required: true
    },

    /**
     * @type {String}
     */
    label: {
      type: String,
      required: true
    }
  }
};
</script>
