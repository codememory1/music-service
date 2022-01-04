<template>
  <security-modal ref="securityModal" title="Change Password">
    <!-- Form START -->
    <template v-slot:form>
      <security-modal-form button-label="Change password">
        <security-modal-field
          type="password"
          label="Old password"
          icon-class="fa-key"
          v-model="oldPassword"
        />
        <security-modal-field
          type="password"
          label="New password"
          icon-class="fa-key"
          v-model="newPassword"
        />
        <security-form-field
          type="password"
          label="Repeat password"
          icon-class="fa-key"
          v-model="repeatPassword"
        />
      </security-modal-form>
    </template>
    <!-- Form END -->
  </security-modal>
</template>
<script>
import SecurityModal from "./SecurityModalComponent";
import SecurityModalForm from "../Forms/SecurityModalFormComponent";
import SecurityModalField from "../Fields/SecurityModalFieldComponent";

export default {
  name: "PasswordRecoverModalComponent",
  components: {
    SecurityModal,
    SecurityModalForm,
	SecurityModalField
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
