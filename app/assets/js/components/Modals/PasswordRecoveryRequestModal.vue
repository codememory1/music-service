<template>
  <security-modal ref="securityModal" title="Password Recovery">
    <template #form>
      <security-modal-form
        button-label="Submit a restore request"
        @click="$emit('recovery')"
      >
        <security-modal-form-field
          label="Email"
          fa-class="fa-envelope"
          v-model="email"
        />
      </security-modal-form>
    </template>
  </security-modal>
</template>

<script>
import SecurityModal from "./SecurityModal";
import SecurityModalForm from "../Forms/SecurityModalForm";
import SecurityModalFormField from "../FormFields/SecurityModalFormField";

export default {
  name: "PasswordRecoveryRequestModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityModalFormField
  },

  data: () => ({
    email: null
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
