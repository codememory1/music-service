<template>
  <header class="header" aria-label="Home header">
    <!-- Initializing modal windows START -->
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
    <password-recovery-request-modal
      ref="passwordRecoveryModal"
      @recovery="recoveryPassword"
    />
    <password-recovery-modal ref="changePasswordModal" />
    <!-- Initializing modal windows END -->

    <div class="container">
      <!-- Header navbar START -->
      <div class="header-navbar">
        <!-- Header logo START -->
        <div class="header-logo">
          <img-alias alias="logo" alt="logo" />
        </div>
        <!-- Header logo END -->

        <div class="header-navbar-right-info">
          <the-home-navigation
            :register-modal="$refs.registerModal"
            :auth-modal="$refs.authModal"
          >
            <li
              v-if="!isAuth"
              class="navigation__item"
              role="presentation"
              @click.prevent="$refs.registerModal.open()"
            >
              <a href="#" role="menuitem">Sign up</a>
            </li>
            <li
              v-if="!isAuth"
              class="navigation__item"
              role="presentation"
              @click.prevent="$refs.authModal.open()"
            >
              <a href="#" role="menuitem">Sing in</a>
            </li>
          </the-home-navigation>

          <base-select
            class="header__lang"
            placeholder="Выберите язык"
            :options="languages"
            :selected-options="selectedLanguage"
            :with-search="true"
            @change="changeLanguage"
          />

          <the-home-header-user />
        </div>
      </div>
      <!-- Header navbar END -->

      <the-home-header-content />
    </div>
  </header>
</template>

<script>
import { mapGetters } from "vuex";
import AuthModal from "../Modals/AuthModal";
import RegisterModal from "../Modals/RegisterModal";
import PasswordRecoveryRequestModal from "../Modals/PasswordRecoveryRequestModal";
import PasswordRecoveryModal from "../Modals/PasswordRecoveryModal";
import TheHomeNavigation from "../Navigations/TheHomeNavigation";
import BaseSelect from "../Selects/BaseSelect.vue";
import TheHomeHeaderContent from "./TheHomeHeaderContent";
import TheHomeHeaderUser from "./TheHomeHeaderUser";

export default {
  name: "TheHomeHeader",
  components: {
    AuthModal,
    RegisterModal,
    PasswordRecoveryRequestModal,
    PasswordRecoveryModal,
    TheHomeNavigation,
    BaseSelect,
    TheHomeHeaderContent,
    TheHomeHeaderUser
  },

  data: () => ({
    languages: [
      {
        label: "Albanian",
        value: "sq"
      },
      {
        label: "English",
        value: "en"
      },
      {
        label: "Arab",
        value: "ar"
      },
      {
        label: "Armenian",
        value: "hy"
      },
      {
        label: "Bashkir",
        value: "ba"
      },
      {
        label: "Belorussian",
        value: "be"
      },
      {
        label: "Bengal",
        value: "bn"
      },
      {
        label: "Burmese",
        value: "my"
      },
      {
        label: "Bulgarian",
        value: "bg"
      },
      {
        label: "Bosnian",
        value: "bs"
      },
      {
        label: "Hungarian",
        value: "hu"
      },
      {
        label: "Venda",
        value: "ve"
      },
      {
        label: "Vietnamese",
        value: "vi"
      },
      {
        label: "Greenlandic",
        value: "kl"
      },
      {
        label: "Greek",
        value: "el"
      },
      {
        label: "Georgian",
        value: "ka"
      },
      {
        label: "Irish",
        value: "ga"
      },
      {
        label: "Icelandic",
        value: "is"
      },
      {
        label: "Spanish",
        value: "es"
      },
      {
        label: "Italian",
        value: "it"
      },
      {
        label: "Kazakh",
        value: "kk"
      },
      {
        label: "Kannada",
        value: "kn"
      },
      {
        label: "Chinese",
        value: "zh"
      },
      {
        label: "Korean",
        value: "ko"
      },
      {
        label: "Latin",
        value: "la"
      },
      {
        label: "Latvian",
        value: "lv"
      },
      {
        label: "Lithuanian",
        value: "lt"
      },
      {
        label: "Luxembourgish",
        value: "lb"
      },
      {
        label: "Marshall",
        value: "mh"
      },
      {
        label: "Moldavian",
        value: "md"
      },
      {
        label: "Mongolian",
        value: "mn"
      },
      {
        label: "Deutsch",
        value: "de"
      },
      {
        label: "Nepali",
        value: "ni"
      },
      {
        label: "Persian",
        value: "fa"
      },
      {
        label: "Polish",
        value: "pl"
      },
      {
        label: "Russian",
        value: "ru"
      },
      {
        label: "French",
        value: "fr"
      },
      {
        label: "Czech",
        value: "cs"
      },
      {
        label: "Swedish",
        value: "sv"
      }
    ],
    selectedLanguage: []
  }),

  computed: {
    ...mapGetters({
      isAuth: "auth/isAuth",
      authUserData: "auth/getUserData",
      language: "translation/lang"
    })
  },

  mounted() {
    this.$store.dispatch("auth/loadUserData");
    this.selectedLanguage.push(this.language);
  },

  methods: {
    /**
     * Handler for clicking on the password button
     */
    recoveryPassword() {
      this.$refs.passwordRecoveryModal.close();
      this.$refs.changePasswordModal.open();
    },

    /**
     * Handler change language
     *
     * @param selected
     */
    changeLanguage(selected) {
      this.$store.commit("translation/setLang", selected[0]);
    }
  }
};
</script>

<style lang="scss" scoped>
@import "../../../scss/components/headers/the-home-header";
</style>
