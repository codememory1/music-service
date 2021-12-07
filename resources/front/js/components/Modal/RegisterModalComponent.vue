<template>
  <security-modal ref="securityModal" title="Sign Up">
    <!-- Form START -->
    <template v-slot:form>
      <security-modal-form button-label="Create account">
        <!-- Form Fields START -->
        <security-form-field
          label="Name"
          icon-class="fa-id-card"
          :value="name"
          v-model="name"
        />
        <security-form-field
          label="Email"
          icon-class="fa-envelope"
          :value="email"
          v-model="email"
        />
        <security-form-field
          label="Password"
          icon-class="fa-key"
          type="password"
          :value="password"
          v-model="password"
        />
        <security-form-field
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
      <div class="text-after-button">
        <p>
          Does the account already exist?
          <span tabindex="0" @click.prevent="$emit('openAuthModal')">
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
import SecurityModalForm from "./SecurityModalFormComponent";
import SecurityFormField from "./SecurityFormFieldComponent";

export default {
  name: "RegisterModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityFormField
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
@import "../../../scss/variables";

.text-after-button {
  margin-top: 30px;
  margin-bottom: 55px;

  p {
    font-size: 14px;
    font-weight: 400;
    color: #fff;
    text-align: center;
    margin: 7px 0;

    span {
      color: $accent;
      transition: color 0.2s ease-in-out;
      cursor: pointer;

      &:hover {
        color: darken($accent, 10%);
      }
    }
  }
}
</style>
