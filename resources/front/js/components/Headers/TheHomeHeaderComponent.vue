<template>
  <header class="header" role="banner">
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

    <div class="container">
      <!-- Header navbar START -->
      <div class="header-navbar">
        <!-- Header logo START -->
        <div class="header-logo">
          <img-alias alias="logo" alt="logo" />
        </div>
        <!-- Header logo END -->

        <div class="header-navbar-right-info">
          <!-- Navigation START -->
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
          <!-- Navigation END -->

          <!-- Select Lang START -->
          <base-select
            class="header__lang"
            placeholder="Выберите язык"
            :options="languages"
            :selected-options="selectedLanguage"
            :with-search="true"
            @change="changeLanguage"
          />
          <!-- Select Lang END -->

          <!-- Navbar user profile START -->
          <div v-if="isAuth" class="header-navbar-user-profile">
            <a :href="playerUrl">
              <img src="/public/images/user.png" :alt="authUserData.name" />
            </a>
          </div>
          <!-- Navbar user profile END -->
        </div>
      </div>
      <!-- Header navbar END -->

      <!-- Header content START -->
      <div class="header-content">
        <div class="header-content-left">
          <h1 class="header__heading" role="heading">
            Listening is everything in your life
          </h1>
          <p>
            Millions of songs and podcasts. No credit card. of songs and
            podcasts. No credit card.
          </p>
          <base-link-button link="#" class="header-content-button bg--accent">
            Create account
          </base-link-button>
        </div>
        <div class="header-content-right">
          <img src="public/images/mockup.png" alt="mockup" />
        </div>
      </div>
      <!-- Header content STOP -->
    </div>
  </header>
</template>
<script>
import { mapGetters } from "vuex";
import BaseSelect from "../../components/Select/BaseSelectComponent";
import AuthModal from "../../components/Modal/AuthModalComponent";
import RegisterModal from "../../components/Modal/RegisterModalComponent";
import PasswordRecoveryRequestModal from "../Modal/PasswordRecoveryRequestModalComponent";
import PasswordRecoveryModal from "../Modal/PasswordRecoveryModalComponent";
import Config from "../../modules/Config";
import BaseLinkButton from "../Buttons/BaseLinkButtonComponent";
import TheHomeNavigation from "../Navigation/TheHomeNavigationComponent";

export default {
  name: "TheHomeHeaderComponent",
  components: {
    BaseSelect,
    AuthModal,
    RegisterModal,
    PasswordRecoveryRequestModal,
    PasswordRecoveryModal,
    BaseLinkButton,
    TheHomeNavigation
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
    }),

    playerUrl() {
      return Config.player_url;
    }
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
@import "../../../scss/components/headers/home";
</style>
