<template>
  <BaseModal ref="modal" :title="$t('password_recovery')">
    <div class="modal-fields">
      <BaseInputModal
        :class="{ error: entryDataError.email }"
        :placeholder="$t('enter_your_email')"
        @input="emailEntry"
      />
    </div>
    <BaseButton class="btn-auth button_bg--accent" :is-loading="requestInProcess" @click="send">
      {{ $t('send_code') }}
    </BaseButton>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Emit, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BaseInputModal from '~/components/UI/Input/BaseInputModal.vue';
import BaseCheckbox from '~/components/UI/Checkbox/BaseCheckbox.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/PasswordProgressBar.vue';
import { PasswordRecoveryRequestEntryData } from '~/types/ModalEntryData';
import PasswordRecoveryRequest from '~/api/requests/PasswordRecoveryRequest';
import isEmpty from '~/utils/is-empty';
import { PasswordRecoveryRequestResponseType } from '~/api/responses/PasswordRecoveryRequestResponseType';
import { ErrorResponseType } from '~/types/ErrorResponseType';
import { getAlertModule } from '~/store';

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar
  }
})
export default class PasswordRecovery extends Vue {
  private requestInProcess: boolean = false;
  private entryData: PasswordRecoveryRequestEntryData = {
    email: null
  };

  private entryDataError = {
    email: false
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

  private get passwordRecoveryRequest(): PasswordRecoveryRequest {
    return new PasswordRecoveryRequest(this.$api);
  }

  private emailEntry(event: InputEvent): void {
    this.entryData.email = (event.target as HTMLInputElement).value;
  }

  private send(): void {
    this.entryDataError.email = isEmpty(this.entryData.email);

    if (!Object.values(this.entryDataError).includes(true)) {
      const response = this.passwordRecoveryRequest.send(
        this.$config.apiClientHost,
        this.entryData
      );

      this.requestInProcess = true;

      response
        .then((success) => {
          this.successPasswordRecoveryPassword(success.success!);
        })
        .catch((error) => {
          this.failedPasswordRecoveryPassword(error.error!);
        })
        .finally(() => {
          this.requestInProcess = false;
        });
    }
  }

  private successPasswordRecoveryPassword(response: PasswordRecoveryRequestResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.password_recovery_request'),
      message: this.$t('alert.message.success_password_recovery_request'),
      isSuccess: true,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.close();

    this.$emit('successRequest', response, this.entryData);
  }

  private failedPasswordRecoveryPassword(response: ErrorResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.password_recovery_request'),
      message: this.$t(response.error.message, response.error.message_parameters),
      isSuccess: false,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
