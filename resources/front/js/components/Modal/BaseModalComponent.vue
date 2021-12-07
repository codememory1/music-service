<template>
  <div
    ref="modal"
    class="modal"
    :class="{ active: isOpen }"
    @click="closeOutContainer"
  >
    <div class="modal__container">
      <div class="modal__content">
        <div class="modal__close">
          <div class="modal__close--btn" @click="close">
            <i class="fal fa-times"></i>
          </div>
        </div>
        <slot />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "BaseModal",
  props: {
    /**
     * Whether to allow scroll body when modal is open
     *
     * @type {Boolean}
     */
    bodyScroll: {
      type: Boolean,
      default: false,
      required: false
    }
  },

  data: () => ({
    isOpen: false
  }),

  methods: {
    /**
     * Closing a modal window when clicking outside the window
     *
     * @param event
     */
    closeOutContainer(event) {
      if (event.target.contains(this.$refs.modal)) {
        this.close();
      }
    },

    /**
     * Opening a window
     */
    open() {
      this.isOpen = true;

      if (!this.bodyScroll) {
        document.body.style.overflow = "hidden";
      }

      this.$emit("open");
    },

    /**
     * Closing the window
     */
    close() {
      this.isOpen = false;

      if (!this.bodyScroll) {
        document.body.style.overflow = "auto";
      }

      this.$emit("close");
    }
  }
};
</script>
<style lang="scss">
@import "../../../scss/components/modal";
</style>
