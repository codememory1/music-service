<template>
  <security-modal ref="securityModal" title="Password Recovery">
    <template v-slot:form>
      <security-modal-form
        button-label="Submit a restore request"
        @click="$emit('recovery')"
      >
        <security-modal-field
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
