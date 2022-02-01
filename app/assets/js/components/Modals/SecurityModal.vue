<template>
  <base-modal ref="modal" class="security-modal">
    <div class="security-modal__content">
      <h3 class="security-modal__title">{{ title }}</h3>

      <slot name="contentAfterTitle" />
      <slot name="form" />
      <slot name="contentAfterForm" />
    </div>
  </base-modal>
</template>

<script>
import BaseModal from "./BaseModal";

export default {
  name: "SecurityModal",
  components: {
    BaseModal
  },
  props: {
    /**
     * Modal title
     */
    title: {
      type: String,
      required: true
    }
  },

  methods: {
    /**
     * Opening a window
     */
    open() {
      this.$refs.modal.open();
    },

    /**
     * Closing the window
     */
    close() {
      this.$refs.modal.close();
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/modals/security-modal";
</style>
