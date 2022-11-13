<template>
  <BaseModal ref="modal" :title="$t('authorization')">
    <div class="modal-fields">
      <BaseInputModal
        :class="{ error: entryDataError.email }"
        :placeholder="$t('enter_your_email')"
        @input="emailEntry"
      />
      <BaseInputModal
        :class="{ error: entryDataError.password }"
        input-type="password"
        :placeholder="$t('enter_your_password')"
        @input="passwordEntry"
      />
    </div>
    <BaseButton class="btn-auth button_bg--accent" :is-loading="requestInProcess" @click="auth">
      {{ $t('login') }}
    </BaseButton>

    <div class="auth-from-social">
      <p class="auth-from-social__text">{{ $t('or_via_social_network') }}</p>

      <div class="auth-from-social-icons">
        <a href="" class="auth-from-social__item">
          <i class="fab fa-google" />
        </a>
        <a href="" class="auth-from-social__item">
          <i class="fab fa-facebook-f" />
        </a>
        <a href="" class="auth-from-social__item">
          <i class="fab fa-twitter" />
        </a>
      </div>
    </div>

    <div class="switch-to-another-modal-container row-grid grid-gap-5">
      <div class="security-modal__switch-to-another-modal">
        {{ $t('dont_have_account') }}
        <a class="link__switch-to-another-modal" @click="$emit('openRegisterModal')">
          {{ $t('register') }}
        </a>
      </div>
      <div class="security-modal__switch-to-another-modal">
        {{ $t('forgot_your_password_q') }}
        <a class="link__switch-to-another-modal" @click="$emit('openPasswordRecoveryModal')">
          {{ $t('restore_password') }}
        </a>
      </div>
    </div>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Emit, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BaseInputModal from '~/components/UI/Input/BaseInputModal.vue';
import BaseCheckbox from '~/components/UI/Checkbox/BaseCheckbox.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/PasswordProgressBar.vue';
import { AuthorizationEntryData } from '~/types/ModalEntryData';
import AuthorizationRequest from '~/api/requests/AuthorizationRequest';
import { AuthorizationResponseType } from '~/api/responses/AuthorizationResponseType';
import { getAlertModule, getUserModule } from '~/store';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import isEmpty from '~/utils/is-empty';

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar
  }
})
export default class AuthorizationModal extends Vue {
  private requestInProcess: boolean = false;
  private entryData: AuthorizationEntryData = {
    email: null,
    password: null
  };

  private entryDataError = {
    email: false,
    password: false
  };

  @Emit('open')
  public open(): void {
    const modal = this.$refs.modal as BaseModal;

    modal.open();
  }

  @Emit('close')
  public close(): void {
    const modal = this.$refs.modal as BaseModal;

    modal.close();
  }

  private emailEntry(event: InputEvent): void {
    this.entryData.email = (event.target as HTMLInputElement).value;
  }

  private passwordEntry(event: InputEvent): void {
    this.entryData.password = (event.target as HTMLInputElement).value;
  }

  get authorizationRequest(): AuthorizationRequest {
    return new AuthorizationRequest(this.$api);
  }

  private auth(): void {
    this.entryDataError.email = isEmpty(this.entryData.email);
    this.entryDataError.password = isEmpty(this.entryData.password);

    if (!Object.values(this.entryDataError).includes(true)) {
      const response = this.authorizationRequest.send(
        this.$config.apiClientHost as string,
        this.entryData
      );

      this.requestInProcess = true;

      response
        .then((success) => {
          this.successAuth(success.success!);
        })
        .catch((error) => {
          this.failedAuth(error.error);
        })
        .finally(() => {
          this.requestInProcess = false;
        });
    }
  }

  private successAuth(response: AuthorizationResponseType): void {
    getUserModule(this.$store).setAccessToken(response.data.access_token);
    getUserModule(this.$store).setRefreshToken(response.data.refresh_token);

    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.auth'),
      message: this.$t('alert.message.success_auth'),
      isSuccess: true,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.close();

    this.$emit('successAuth', response);
  }

  private failedAuth(response: ErrorResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.auth'),
      message: this.$t(response.error.message, response.error.message_parameters),
      isSuccess: false,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('failedAuth', response);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
@import '@/assets/scss/business/modal/auth-modal';
</style>
