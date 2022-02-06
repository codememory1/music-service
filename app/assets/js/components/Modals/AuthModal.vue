<template>
  <security-modal ref="securityModal" title="Sign In" class="modal-auth">
    <!-- Other authorization methods START -->
    <template #contentAfterTitle>
      <div class="modal-auth-methods-auth">
        <div class="modal-auth__method-auth apple">
          <i class="fab fa-apple"></i>
        </div>
        <div class="modal-auth__method-auth google">
          <i class="fab fa-google"></i>
        </div>
        <div class="modal-auth__method-auth facebook">
          <i class="fab fa-facebook-f"></i>
        </div>
      </div>
    </template>
    <!-- Other authorization methods END -->

    <!-- Form START -->
    <template #form>
      <security-modal-form
        button-label="Sing in to your account"
        :button-is-loading="btnIsLoading"
        @click="signIn"
      >
        <!-- Form Fields START -->
        <security-modal-form-field
          label="Login"
          fa-class="fa-user"
          v-model="login"
        />
        <security-modal-form-field
          label="Password"
          fa-class="fa-key"
          type="password"
          v-model="password"
        />
        <!-- Form Fields END -->

        <!-- Checkbox remember data on this device START -->
        <div class="modal-auth-remember-wrapper">
          <input
            type="checkbox"
            class="checkbox"
            id="remember-label"
            @input="remember = !remember"
          />
          <label for="remember-label">Remember on this device</label>
        </div>
        <!-- Checkbox remember data on this device END -->
      </security-modal-form>
    </template>
    <!-- Form END -->

    <!-- Other useful links START -->
    <template #contentAfterForm>
      <security-modal-other-links>
        <security-modal-other-link
          text="Don't have an account?"
          button-label="Create an account"
          @click="$emit('openRegisterModal')"
        />
        <security-modal-other-link
          text="Forgot your password?"
          button-label="Restore password"
          @click="$emit('openPasswordRecoveryModal')"
        />
      </security-modal-other-links>
    </template>
    <!-- Other useful links END -->
  </security-modal>
</template>

<script>
import { mapGetters } from "vuex";
import SecurityModal from "./SecurityModal";
import SecurityModalForm from "../Forms/SecurityModalForm";
import SecurityModalFormField from "../FormFields/SecurityModalFormField";
import SecurityModalOtherLinks from "./SecurityModalOtherLinks";
import SecurityModalOtherLink from "./SecurityModalOtherLink";
import ResponseAuth from "../../api/auth";

export default {
  name: "AuthModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityModalFormField,
    SecurityModalOtherLinks,
    SecurityModalOtherLink
  },

  computed: {
    ...mapGetters({
      lang: "translation/lang"
    })
  },

  data: () => ({
    login: null,
    password: null,
    remember: false,
    btnIsLoading: false
  }),

  created() {
    this.login = this.$storage.getByKey("auth_data", "login");
  },

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
    },

    /**
     * Handler when clicking on the authorization button
     */
    async signIn() {
      this.btnIsLoading = true;

      if (this.remember) {
        this.$storage.create("auth_data", {
          login: this.login
        });
      }

      const authResponse = await ResponseAuth(
        this.login ?? "",
        this.password ?? ""
      );

      this.responseHandler(authResponse);
    },

    /**
     * Authorization response handler
     *
     * @param response
     */
    responseHandler(response) {
      this.btnIsLoading = false;

      if (response.status >= 400) {
        this.$store.commit("alert/create", {
          type: "error",
          title: "Авторизация",
          message: response.data.message.text
        });
      } else {
        this.successAuth(response);
      }
    },

    /**
     * Successful authorization handler
     *
     * @param response
     */
    successAuth(response) {
      this.$store.commit("alert/create", {
        type: "success",
        title: "Авторизация",
        message: response.data.message.text
      });

      const data = response.data.data ?? {};

      this.installationTokens(data.access_token, data.refresh_token);
      this.zeroingInputData();

      this.$store.dispatch("auth/loadUserData");

      // Closing the modal login window
      this.$refs.securityModal.close();
    },

      /**
       * Setting tokens in localStorage
       *
       * @param accessToken
       * @param refreshToken
       */
    installationTokens(accessToken, refreshToken) {
      this.$store.commit("auth/setAccessToken", accessToken);
      this.$store.commit("auth/setRefreshToken", refreshToken);
    },

    /**
     * Zeroing the login credentials
     */
    zeroingInputData() {
      this.login = null;
      this.password = null;
    }
  }
};
</script>

<style lang="scss">
@import "../../../scss/components/modals/auth-modal";
</style>
