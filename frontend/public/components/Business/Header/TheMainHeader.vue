<template>
  <header class="main-header">
    <RegistrationModal
      ref="registrationModel"
      @openLoginModal="
        $refs.registrationModel.close();
        $refs.authorizationModel.open();
      "
    />
    <AuthorizationModal
      ref="authorizationModel"
      @openRegisterModal="
        $refs.authorizationModel.close();
        $refs.registrationModel.open();
      "
      @openPasswordRecoveryModal="
        $refs.authorizationModel.close();
        $refs.passwordRecoveryModal.open();
      "
      @auth="auth"
    />
    <PasswordRecoveryModal
      ref="passwordRecoveryModal"
      @successSend="
        $refs.passwordRecoveryModal.close();
        $refs.passwordResetModal.open();
      "
    />
    <PasswordResetModal
      ref="passwordResetModal"
      @openLoginModal="
        $refs.passwordResetModal.close();
        $refs.authorizationModel.open();
      "
    />
    <div class="main-header-logo">
      <MainLogo />
    </div>
    <div class="main-header-navigation">
      <MainNavigation @signUp="signUp" @signIn="signIn" />
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
import AuthorizationModal from '~/components/Business/Modal/AuthorizationModal.vue';
import PasswordRecoveryModal from '~/components/Business/Modal/PasswordRecoveryModal.vue';
import PasswordResetModal from '~/components/Business/Modal/PasswordResetModal.vue';
import ApiRouters from '~/api/api-routers';

@Component({
  components: {
    MainLogo,
    MainNavigation,
    BaseSelect,
    RegistrationModal,
    AuthorizationModal,
    PasswordRecoveryModal,
    PasswordResetModal
  }
})
export default class TheMainHeader extends Vue {
  private signUp(): void {
    const modal = this.$refs.registrationModel as RegistrationModal;

    modal.open();
  }

  private signIn(): void {
    const modal = this.$refs.authorizationModel as AuthorizationModal;

    modal.open();
  }

  private auth(): void {
    const modal = this.$refs.authorizationModel as AuthorizationModal;
    const response = this.$api(this.$config.apiClientHost as string, ApiRouters.security.auth);

    console.log(response);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/main-header';
</style>
