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
      :request-in-process="authRequestInProcess"
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
import AuthorizationRequest from '~/api/requests/AuthorizationRequest';
import { getAlertModule, getUserModule } from '~/store';
import { AuthorizationResponseType } from '~/api/responses/AuthorizationResponseType';
import { ErrorResponseType } from '~/types/ErrorResponseType';

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
  private authRequestInProcess: boolean = false;

  private signUp(): void {
    const modal = this.$refs.registrationModel as RegistrationModal;

    modal.open();
  }

  private signIn(): void {
    const modal = this.$refs.authorizationModel as AuthorizationModal;

    modal.open();
  }

  get authorizationRequest(): AuthorizationRequest {
    return new AuthorizationRequest(this.$api);
  }

  private auth(): void {
    this.authRequestInProcess = true;

    const modal = this.$refs.authorizationModel as AuthorizationModal;
    const response = this.authorizationRequest.send(
      this.$config.apiClientHost as string,
      modal.entryData
    );

    response
      .then((success) => {
        this.successAuth(success.success!, modal);
      })
      .catch((error) => {
        this.errorAuth(error.error);
      })
      .finally(() => {
        this.authRequestInProcess = false;
      });
  }

  private successAuth(response: AuthorizationResponseType, modal: AuthorizationModal): void {
    getUserModule(this.$store).setAccessToken(response.data.access_token);
    getUserModule(this.$store).setRefreshToken(response.data.refresh_token);

    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.auth'),
      message: this.$t('alert.message.success_auth'),
      isSuccess: true,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    modal.close();
  }

  private errorAuth(response: ErrorResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.auth'),
      message: this.$t(response.error.message),
      isSuccess: false,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/header/main-header';
</style>
