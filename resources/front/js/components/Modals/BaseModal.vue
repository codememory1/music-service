<template>
  <div
    class="modal"
    aria-haspopup="dialog"
    ref="modal"
    :class="{ active: isOpen }"
    @click="closeOutContainer"
  >
    <div class="modal-container">
      <div class="modal-content" role="document">
        <div class="modal-close">
          <div class="modal-close__btn" @click="close">
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
     */
    isScrollBody: {
      type: Boolean,
      default: false
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

      if (!this.isScrollBody) {
        document.body.style.overflow = "hidden";
      }

      this.$emit("open");
    },

    /**
     * Closing the window
     */
    close() {
      this.isOpen = false;

      if (!this.isScrollBody) {
        document.body.style.overflow = "auto";
      }

      this.$emit("close");
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/modals/base-modal";
</style>
