<template>
  <base-form-button
    @click="$emit('click')"
    class="loading-button"
    :class="{ disabled: isLoading, active: isLoading }"
  >
    <slot />
  </base-form-button>
</template>
<script>
import BaseFormButton from "./BaseFormButtonComponent";

export default {
  name: "LoadingButton",
  components: {
    BaseFormButton
  },

  props: {
    /**
     * Show loader on button
     *
     * @type {Boolean}
     */
    isLoading: {
      type: Boolean,
      default: false,
      required: false
    }
  }
};
</script>
<style lang="scss" scoped>
.loading-button {
  position: relative;

  &.active {
    &:after {
      content: "\f3f4";
      position: absolute;
      font-family: "Font Awesome 5 Pro", sans-serif;
      color: #fff;
      transition: all 0.5s ease;
      animation: rotate 1s linear infinite;
      font-size: 20px;
    }

    &:before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: inherit;
      border-radius: inherit;
    }
  }
}

@keyframes rotate {
  from {
    transform: rotate(360deg);
  }
}
</style>
