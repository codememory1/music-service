<template>
  <security-modal ref="securityModal" title="Password Recovery">
    <!-- Code entry fields START -->
    <template #contentAfterTitle>
      <code-field ref="code" :max-number="5" style="justify-content: center" />
    </template>
    <!-- Code entry fields END -->

    <!-- Form START -->
    <template #form>
      <security-modal-form button-label="Change password">
        <security-modal-form-field
          type="password"
          label="Password"
          fa-class="fa-key"
          v-model="password"
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
import CodeField from "../FormFields/CodeField.vue";
import SecurityModalFormField from "../FormFields/SecurityModalFormField";

export default {
  name: "PasswordRecoveryModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    CodeField,
    SecurityModalFormField
  },

  data: () => ({
    password: null,
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
