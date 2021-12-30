<template>
  <security-modal ref="securityModal" title="Password Recovery">
    <template v-slot:form>
      <security-modal-form
        button-label="Submit a restore request"
        @click="$emit('recovery')"
      >
        <security-form-field
          label="Email"
          icon-class="fa-envelope"
          v-model="email"
        />
      </security-modal-form>
    </template>
  </security-modal>
</template>
<script>
import SecurityModal from "./SecurityModalComponent";
import SecurityModalForm from "./SecurityModalFormComponent";
import SecurityFormField from "./SecurityFormFieldComponent";

export default {
  name: "PasswordRecoverModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityFormField
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
