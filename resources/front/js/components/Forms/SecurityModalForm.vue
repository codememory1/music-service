<template>
  <form class="security-modal-form" @submit.prevent>
    <slot />

    <!-- Button wrapper START -->
    <div class="security-modal-form-button-wrapper">
      <loading-button
        class="security-modal-form__button bg--accent"
        :is-loading="buttonIsLoading"
        @click="$emit('click', $event)"
      >
        {{ buttonLabel }}
      </loading-button>
    </div>
    <!-- Button wrapper END -->
  </form>
</template>

<script>
import LoadingButton from "../Buttons/LoadingButton";

export default {
  name: "SecurityModalForm",
  components: {
    LoadingButton
  },
  props: {
    /**
     * Label button
     */
    buttonLabel: {
      type: String,
      required: true
    },

    /**
     * Show loader on button
     */
    buttonIsLoading: {
      type: Boolean,
      default: false
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/forms/security-modal-form";
</style>
