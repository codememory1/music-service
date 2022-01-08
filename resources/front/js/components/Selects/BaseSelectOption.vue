<template>
  <li
    role="option"
    class="select__option"
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
  name: "BaseSelectOption",
  props: {
    /**
     * Option label
     */
    label: {
      type: String,
      required: true
    },

    /**
     * Is active option
     */
    isActive: {
      type: Boolean,
      required: true
    },

    /**
     * Is disabled option
     */
    isDisabled: {
      type: Boolean,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/selects/base-select-option";
</style>
