<template>
  <security-modal ref="securityModal" title="Sign In">
    <!-- Other authorization methods START -->
    <template v-slot:contentAfterTitle>
      <div class="methods-auth">
        <div class="method-auth apple">
          <i class="fab fa-apple"></i>
        </div>
        <div class="method-auth google">
          <i class="fab fa-google"></i>
        </div>
        <div class="method-auth facebook">
          <i class="fab fa-facebook-f"></i>
        </div>
      </div>
    </template>
    <!-- Other authorization methods END -->

    <!-- Form START -->
    <template v-slot:form>
      <security-modal-form
        button-label="Sing in to your account"
        @click="signIn"
      >
        <!-- Form Fields START -->
        <security-form-field
          label="Login"
          icon-class="fa-user"
          v-model="login"
        />
        <security-form-field
          label="Password"
          icon-class="fa-key"
          :type="password"
          v-model="password"
        />
        <!-- Form Fields END -->

        <!-- Checkbox remember data on this device START -->
        <div class="remember-data__wrap">
          <input
            type="checkbox"
            class="checkbox"
            id="remember-data"
            @input="remember = !remember"
          />
          <label for="remember-data">Remember on this device</label>
        </div>
        <!-- Checkbox remember data on this device END -->
      </security-modal-form>
    </template>
    <!-- Form END -->

    <!-- Other useful links START -->
    <template v-slot:contentAfterForm>
      <div class="text-after-button">
        <p>
          Don't have an account?
          <span tabindex="0" @click="$emit('openRegisterModal')">
            Create an account
          </span>
        </p>
        <p>
          Forgot your password?
          <span tabindex="0" @click="$emit('openPasswordRecoveryModal')">
            Restore password
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
  name: "AuthModal",
  components: {
    SecurityModal,
    SecurityModalForm,
    SecurityFormField
  },

  data: () => ({
    login: null,
    password: null,
    remember: false
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
    signIn() {
      if (this.remember) {
        this.$storage.create("auth_data", {
          login: this.login
        });
      }
    }
  }
};
</script>
<style lang="scss" scoped>
@import "../../../scss/variables";

.methods-auth {
  display: flex;
  justify-content: center;
  padding-bottom: 30px;
  margin-left: 80px;
  margin-right: 80px;
  margin-bottom: 30px;
}

.method-auth {
  width: 47px;
  height: 47px;
  background-color: $dark-bg;
  margin-right: 25px;
  border-radius: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;

  &:last-of-type {
    margin-right: 0;
  }

  &.apple {
    i {
      font-size: 25px;
    }
  }

  &.facebook {
    i {
      font-size: 21px;
    }
  }

  i {
    color: $accent;
    font-size: 19px;
  }

  &:hover {
    background-color: lighten($dark-bg, 10%);
  }
}

.remember-data__wrap {
  display: flex;
  cursor: pointer;
  margin-bottom: 40px;
  align-items: center;

  label {
    color: #fff;
    font-size: 12px;
    font-weight: 500;
    margin-left: 10px;
    margin-top: 2px;
    align-items: center;
  }
}

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
