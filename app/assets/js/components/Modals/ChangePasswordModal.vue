<template>
  <security-modal ref="securityModal" title="Change Password">
    <!-- Form START -->
    <template #form>
      <security-modal-form button-label="Change password">
        <security-modal-form-field
          type="password"
          label="Old password"
          fa-class="fa-key"
          v-model="oldPassword"
        />
        <security-modal-form-field
          type="password"
          label="New password"
          fa-class="fa-key"
          v-model="newPassword"
        />
        <security-modal-form-field
          type="password"
          label="Repeat password"
          fa-class="fa-key"
          v-model="repeatPassword"
        />
      </security-modal-form>
    </template>
    <!-- Form END -->
  </security-modal>
</template>

<script>
import SecurityModal from "./SecurityModal";
import SecurityModalForm from "../Forms/SecurityModalForm";
import SecurityModalFormField from "../FormFields/SecurityModalFormField";

export default {
  name: "ChangePasswordModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityModalFormField
  },

  data: () => ({
    oldPassword: null,
    newPassword: null,
    repeatPassword: null
  }),

  methods: {
    /**
     * Opening a window
     */
    open() {
      this.$refs.securityModal.open();
    },

    /**
     * Closing the window
     */
    close() {
      this.$refs.securityModal.close();
    }
  }
};
</script>
