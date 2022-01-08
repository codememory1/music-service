<template>
  <security-modal ref="securityModal" title="Sign Up">
    <!-- Form START -->
    <template #form>
      <security-modal-form button-label="Create account">
        <!-- Form Fields START -->
        <security-modal-form-field
          label="Name"
          fa-class="fa-id-card"
          :value="name"
          v-model="name"
        />
        <security-modal-form-field
          label="Email"
          fa-class="fa-envelope"
          :value="email"
          v-model="email"
        />
        <security-modal-form-field
          label="Password"
          fa-class="fa-key"
          type="password"
          :value="password"
          v-model="password"
        />
        <security-modal-form-field
          label="Repeat password"
          fa-class="fa-key"
          type="password"
          :value="repeatPassword"
          v-model="repeatPassword"
        />
        <!-- Form Fields END -->
      </security-modal-form>
    </template>
    <!-- Form END -->

    <!-- Other useful links START -->
    <template #contentAfterForm>
      <security-modal-other-links>
        <security-modal-other-link
          button-label="Does the account already exist?"
          text="Sign in to your account"
          @click.prevent="$emit('openAuthModal')"
        />
      </security-modal-other-links>
    </template>
    <!-- Other useful links END -->
  </security-modal>
</template>

<script>
import SecurityModal from "./SecurityModal";
import SecurityModalForm from "../Forms/SecurityModalForm";
import SecurityModalFormField from "../FormFields/SecurityModalFormField";
import SecurityModalOtherLinks from "./SecurityModalOtherLinks";
import SecurityModalOtherLink from "./SecurityModalOtherLink";

export default {
  name: "RegisterModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityModalFormField,
    SecurityModalOtherLinks,
    SecurityModalOtherLink
  },

  data: () => ({
    name: null,
    email: null,
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
