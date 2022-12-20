<template>
  <BaseModal ref="modal" :title="$t('account_activation')">
    <div class="modal-fields">
      <InputCode
        ref="code"
        :active-square-number="1"
        :count-squares="6"
        class="input-code-squares--center"
      />
    </div>

    <BaseButton class="btn-auth button_bg--accent" :is-loading="requestIsProcess" @click="activate">
      {{ $t('activate') }}
    </BaseButton>
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
import AccountActivationRequest from '~/api/requests/AccountActivationRequest';
import { AccountActivationResponseType } from '~/api/responses/AccountActivationResponseType';
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
export default class AccountActivationModal extends Vue {
  private requestIsProcess: boolean = false;
  private email: string | null = null;

  public open(email: string): void {
    (this.$refs.modal as BaseModal).open();

    this.email = email;
  }

  public close(): void {
    (this.$refs.modal as BaseModal).close();
  }

  private get accountActivationRequest(): AccountActivationRequest {
    return new AccountActivationRequest(this.$api);
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
  private activate(): void {
    const inputCode = this.$refs.code as InputCode;

    this.inputCodeValidation();

    if (inputCode.isOk) {
      const response = this.accountActivationRequest.send(this.$config.apiClientHost as string, {
        email: this.email!,
        code: inputCode.codes.join('')
      });

      this.requestIsProcess = true;

      response
        .then((success) => {
          this.successActivate(success.success!);
        })
        .catch((error) => {
          this.failedActivate(error.error!);
        })
        .finally(() => {
          this.requestIsProcess = false;
        });
    }
  }

  private successActivate(response: AccountActivationResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.account_activation'),
      message: this.$t('alert.message.success_account_activate'),
      isSuccess: true,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('successActivate', response);
  }

  private failedActivate(response: ErrorResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.account_activation'),
      message: this.$t(response.error.message, response.error.message_parameters),
      isSuccess: false,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('failedActive', response);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
