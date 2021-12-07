<template>
  <base-modal ref="modal" class="security__modal">
    <div class="security__modal_content">
      <h3 class="security__modal_title">{{ title }}</h3>
      <slot name="contentAfterTitle" />
      <slot name="form" />
      <slot name="contentAfterForm" />
    </div>
  </base-modal>
</template>
<script>
import BaseModal from "../../components/Modal/BaseModalComponent";

export default {
  name: "SecurityModal",
  components: {
    BaseModal
  },

  props: {
    /**
     * Modal name
     *
     * @type {String}
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
<style lang="scss" scoped>
@import "../../../scss/components/security";
</style>
