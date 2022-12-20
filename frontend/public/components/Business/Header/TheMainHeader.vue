<template>
  <header class="main-header">
    <RegistrationModal
      ref="registrationModal"
      @openLoginModal="
        $refs.registrationModal.close();
        $refs.authorizationModal.open();
      "
      @successRegister="successRegister"
    />
    <AccountActivationModal
      ref="accountActivationModal"
      @successActivate="
        $refs.accountActivationModal.close();
        $refs.authorizationModal.open();
      "
    />
    <AuthorizationModal
      ref="authorizationModal"
      :request-in-process="authRequestInProcess"
      @openRegisterModal="
        $refs.authorizationModal.close();
        $refs.registrationModal.open();
      "
      @openPasswordRecoveryModal="
        $refs.authorizationModal.close();
        $refs.passwordRecoveryModal.open();
      "
    />
    <PasswordRecoveryModal
      ref="passwordRecoveryModal"
      @successRequest="successPasswordRecoveryRequest"
    />
    <ResetPasswordModal
      ref="resetPasswordModal"
      @openLoginModal="
        $refs.resetPasswordModal.close();
        $refs.authorizationModal.open();
      "
      @successResetPassword="
        $refs.resetPasswordModal.close();
        $refs.authorizationModal.open();
      "
    />
    <div class="main-header-logo">
      <MainLogo />
    </div>
    <div class="main-header-navigation">
      <MainNavigation
        @signUp="$refs.registrationModal.open()"
        @signIn="$refs.authorizationModal.open()"
      />
      <BaseSelect
        class="main-header__select-lang"
        placeholder="Lang"
        :options="[
          { key: 'en', value: 'En' },
          { key: 'ru', value: 'Ru' }
        ]"
        :active-options="['en']"
      />
    </div>
  </header>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import MainLogo from '~/components/Business/Logo/MainLogo.vue';
import MainNavigation from '~/components/Business/Navigation/MainNavigation.vue';
import BaseSelect from '~/components/UI/Select/BaseSelect.vue';
import RegistrationModal from '~/components/Business/Modal/RegistrationModal.vue';
import AccountActivationModal from '~/components/Business/Modal/AccountActivationModal.vue';
import AuthorizationModal from '~/components/Business/Modal/AuthorizationModal.vue';
import PasswordRecoveryModal from '~/components/Business/Modal/PasswordRecoveryModal.vue';
import ResetPasswordModal from '~/components/Business/Modal/ResetPasswordModal.vue';
import { RegistrationResponseType } from '~/api/responses/RegistrationResponseType';
import { PasswordRecoveryRequestEntryData, RegistrationEntryData } from '~/types/ModalEntryData';
import { PasswordRecoveryRequestResponseType } from '~/api/responses/PasswordRecoveryRequestResponseType';

@Component({
  components: {
    MainLogo,
    MainNavigation,
    BaseSelect,
    RegistrationModal,
    AccountActivationModal,
    AuthorizationModal,
    PasswordRecoveryModal,
    ResetPasswordModal
  }
})
export default class TheMainHeader extends Vue {
  private authRequestInProcess: boolean = false;

  private successRegister(
    _response: RegistrationResponseType,
    entryData: RegistrationEntryData
  ): void {
    (this.$refs.accountActivationModal as AccountActivationModal).open(entryData.email!);
  }

  private successPasswordRecoveryRequest(
    _response: PasswordRecoveryRequestResponseType,
    entryData: PasswordRecoveryRequestEntryData
  ): void {
    (this.$refs.passwordRecoveryModal as PasswordRecoveryModal).close();
    (this.$refs.resetPasswordModal as ResetPasswordModal).open(entryData.email!);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/main-header';
</style>
