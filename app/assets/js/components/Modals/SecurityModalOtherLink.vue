<template>
  <div class="security-modal-other-link">
    {{ text }}
    <span
      class="security-modal-other-link__button"
      tabindex="-1"
      role="button"
      @click="$emit('click', $event)"
    >
      {{ buttonLabel }}
    </span>
  </div>
</template>

<script>
export default {
  name: "SecurityModalOtherLink",
  props: {
    /**
     * Text before button label
     */
    text: {
      type: String,
      required: true
    },

    /**
     * Button label
     */
    buttonLabel: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/modals/security-modal-other-link";
</style>
