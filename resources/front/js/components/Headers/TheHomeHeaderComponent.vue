<template>
  <header class="header">
    <auth-modal
      ref="authModal"
      @openRegisterModal="
        $refs.authModal.close();
        $refs.registerModal.open();
      "
      @openPasswordRecoveryModal="
        $refs.authModal.close();
        $refs.passwordRecoveryModal.open();
      "
    />
    <register-modal
      ref="registerModal"
      @openAuthModal="
        $refs.registerModal.close();
        $refs.authModal.open();
      "
    />
    <password-recovery-modal
      ref="passwordRecoveryModal"
      @recovery="recoveryPassword"
    />
    <change-password-modal ref="changePasswordModal" />
    <div class="container">
      <div class="header__navbar">
        <div class="header__logo">
          <img-alias alias="logo" alt="logo" />
        </div>
        <div class="navbar__right">
          <div class="header__navigation">
            <ul class="navigation__items">
              <li class="navigation__item">
                <a href="#">Premium</a>
              </li>
              <li class="navigation__item">
                <a href="#">Help</a>
              </li>
              <li class="navigation__item">
                <a href="#">Download</a>
              </li>
              <li
                class="navigation__item"
                @click.prevent="$refs.registerModal.open()"
              >
                <a href="#">Sign up</a>
              </li>
              <li
                class="navigation__item"
                @click.prevent="$refs.authModal.open()"
              >
                <a href="#">Sing in</a>
              </li>
            </ul>
          </div>
          <div class="header__select--lang">
            <base-custom-select
              class="header__lang"
              placeholder="Выберите язык"
              :options="[
                {
                  label: 'English',
                  value: 'en'
                },
                {
                  label: 'Russian',
                  value: 'ru'
                }
              ]"
            />
          </div>
        </div>
      </div>
      <div class="header__content">
        <div class="header__content--left">
          <h1>Listening is everything in your life</h1>
          <p>
            Millions of songs and podcasts. No credit card. of songs and
            podcasts. No credit card.
          </p>
          <a href="#" class="header__content--button">Create account</a>
        </div>
        <div class="header__content--right">
          <img src="public/images/mockup.png" alt="mockup" />
        </div>
      </div>
    </div>
  </header>
</template>
<script>
import BaseCustomSelect from "../../components/Select/BaseSelectComponent";
import AuthModal from "../../components/Modal/AuthModalComponent";
import RegisterModal from "../../components/Modal/RegisterModalComponent";
import PasswordRecoveryModal from "../../components/Modal/PasswordRecoveryModalComponent";
import ChangePasswordModal from "../../components/Modal/ChangePasswordModalComponent";

export default {
  name: "TheHomeHeader",
  components: {
    BaseCustomSelect,
    AuthModal,
    RegisterModal,
    PasswordRecoveryModal,
    ChangePasswordModal
  },

  methods: {
    /**
     * Handler for clicking on the password button
     */
    recoveryPassword() {
      this.$refs.passwordRecoveryModal.close();
      this.$refs.changePasswordModal.open();
    }
  }
};
</script>
