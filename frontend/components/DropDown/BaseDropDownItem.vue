<template>
  <li class="drop-down__item" :class="{ multiple: multiple, disabled }">
    <slot />
    <slot name="drop-down" />
  </li>
</template>

<script>
export default {
  name: "BaseDropDownItem",
  props: {
    multiple: {
      type: Boolean,
      default: false
    },

    disabled: {
      type: Boolean,
      default: false
    },

    toWindow: {
      type: Number,
      default: 0
    },

    backWindow: {
      type: Number,
      default: 0
    }
  }
};
</script>

<style lang="scss">
@import "../../assets/css/components/drop-down/base-drop-down-item";
</style>
