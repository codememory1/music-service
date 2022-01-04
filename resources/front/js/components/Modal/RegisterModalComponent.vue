<template>
  <security-modal ref="securityModal" title="Sign Up">
    <!-- Form START -->
    <template v-slot:form>
      <security-modal-form button-label="Create account">
        <!-- Form Fields START -->
        <security-modal-field
          label="Name"
          icon-class="fa-id-card"
          :value="name"
          v-model="name"
        />
        <security-modal-field
          label="Email"
          icon-class="fa-envelope"
          :value="email"
          v-model="email"
        />
        <security-modal-field
          label="Password"
          icon-class="fa-key"
          type="password"
          :value="password"
          v-model="password"
        />
        <security-modal-field
          label="Repeat password"
          icon-class="fa-key"
          type="password"
          :value="repeatPassword"
          v-model="repeatPassword"
        />
        <!-- Form Fields END -->
      </security-modal-form>
    </template>
    <!-- Form END -->

    <!-- Other useful links START -->
    <template v-slot:contentAfterForm>
      <div class="other-links">
        <p>
          Does the account already exist?
          <span
            tabindex="-1"
            role="button"
            @click.prevent="$emit('openAuthModal')"
          >
            Sign in to your account
          </span>
        </p>
      </div>
    </template>
    <!-- Other useful links END -->
  </security-modal>
</template>
<script>
import SecurityModal from "./SecurityModalComponent";
import SecurityModalForm from "../Forms/SecurityModalFormComponent";
import SecurityModalField from "../Fields/SecurityModalFieldComponent";

export default {
  name: "RegisterModalComponent",
  components: {
    SecurityModal,
    SecurityModalForm,
	SecurityModalField
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
<style lang="scss" scoped>
@import "../../../scss/components/modals/register";
</style>
