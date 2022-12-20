<template>
  <BaseModal ref="modal" :title="$t('reset_password')">
    <div class="modal-fields">
      <InputCode
        ref="code"
        :active-square-number="1"
        :count-squares="6"
        class="input-code-squares--center"
      />
      <BaseInputModal
        class="password-field"
        :class="{ error: entryDataError.password }"
        input-type="password"
        :placeholder="$t('enter_your_password')"
        @input="passwordEntry"
      >
        <template #up>
          <PasswordProgressBar class="above-input" />
        </template>
      </BaseInputModal>
      <BaseInputModal
        input-type="password"
        :class="{ error: entryDataError.password_confirm }"
        :placeholder="$t('enter_your_password_confirmation')"
        @input="passwordConfirmationEntry"
      />
    </div>

    <BaseButton
      :is-loading="requestInProcess"
      class="btn-auth button_bg--accent"
      @click="resetPassword"
    >
      {{ $t('reset_password') }}
    </BaseButton>

    <div class="switch-to-another-modal-container row-grid grid-gap-5">
      <div class="security-modal__switch-to-another-modal">
        {{ $t('have_account_q') }}
        <a class="link__switch-to-another-modal" @click="$emit('openLoginModal')">
          {{ $t('login') }}
        </a>
      </div>
    </div>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue, Emit } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BaseInputModal from '~/components/UI/Input/BaseInputModal.vue';
import BaseCheckbox from '~/components/UI/Checkbox/BaseCheckbox.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/PasswordProgressBar.vue';
import InputCode from '~/components/UI/Input/InputCode.vue';
import ResetPasswordRequest from '~/api/requests/ResetPasswordRequest';
import { ResetPasswordEntryData } from '~/types/ModalEntryData';
import isEmpty from '~/utils/is-empty';
import { ResetPasswordResponseType } from '~/api/responses/ResetPasswordResponseType';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { getAlertModule } from '~/store';

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar,
    InputCode
  }
})
export default class ResetPasswordModal extends Vue {
  private requestInProcess: boolean = false;
  private entryData: ResetPasswordEntryData = {
    email: null,
    code: null,
    password: null,
    password_confirm: null
  };

  private entryDataError = {
    password: false,
    password_confirm: false
  };

  public open(email: string): void {
    this.entryData.email = email;

    (this.$refs.modal as BaseModal).open();
  }

  public close(): void {
    (this.$refs.modal as BaseModal).close();
  }

  private get resetPasswordRequest(): ResetPasswordRequest {
    return new ResetPasswordRequest(this.$api);
  }

  private passwordEntry(event: InputEvent): void {
    this.entryData.password = (event.target as HTMLInputElement).value;
  }

  private passwordConfirmationEntry(event: InputEvent): void {
    this.entryData.password_confirm = (event.target as HTMLInputElement).value;
  }

  private inputCodeValidation(): void {
    const inputCode = this.$refs.code as InputCode;

    inputCode.codes.forEach((v, i) => {
      if (!/^\d+$/.test(v)) {
        inputCode.setErrorSquare(i);
      } else {
        inputCode.removeErrorSquare(i);
      }
    });
  }

  @Emit('resetPassword')
  private resetPassword(): void {
    const inputCode = this.$refs.code as InputCode;

    this.entryDataError.password = isEmpty(this.entryData.password);
    this.entryDataError.password_confirm = isEmpty(this.entryData.password_confirm);

    this.inputCodeValidation();

    if (!Object.values(this.entryDataError).includes(true) && inputCode.isOk) {
      this.entryData.code = inputCode.codes.join('');

      const response = this.resetPasswordRequest.send(this.$config.apiClientHost, this.entryData);

      this.requestInProcess = true;

      response
        .then((success) => {
          this.successResetPassword(success.success!);
        })
        .catch((error) => {
          this.failedResetPassword(error.error!);
        })
        .finally(() => {
          this.requestInProcess = false;
        });
    }
  }

  private successResetPassword(response: ResetPasswordResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.reset_password'),
      message: this.$t('alert.message.success_reset_password'),
      isSuccess: true,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('successResetPassword', response, this.entryData);
  }

  private failedResetPassword(response: ErrorResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.reset_password'),
      message: this.$t(response.error.message, response.error.message_parameters),
      isSuccess: false,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('failedResetPassword', response, this.entryData);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
