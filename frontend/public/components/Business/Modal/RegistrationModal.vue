<template>
  <BaseModal ref="modal" :title="$t('registration')">
    <div class="modal-fields">
      <BaseInputModal
        :placeholder="$t('enter_your_pseudonym')"
        :class="{ error: entryDataError.pseudonym }"
        @input="pseudonymEntry"
      />
      <BaseInputModal
        :placeholder="$t('enter_your_email')"
        :class="{ error: entryDataError.email }"
        @input="emailEntry"
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
        :placeholder="$t('enter_your_password_confirmation')"
        :class="{ error: entryDataError.password_confirm }"
        @input="passwordConfirmEntry"
      />
    </div>
    <div class="security-modal__confirm-platform-rules">
      <BaseCheckbox
        v-model="confirmPlatformRules"
        :class="{ error: entryDataError.confirmedPlatformRules }"
      />
      <p
        class="security-modal__confirm-platform-rules__text"
        v-html="
          $t('by_clicking_register', {
            title: $config.title,
            terms_use_link: '/1',
            privacy_policy_link: '/2'
          })
        "
      />
    </div>
    <BaseButton :is-loading="requestInProcess" class="btn-auth button_bg--accent" @click="register">
      Register
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
import { RegistrationEntryData } from '~/types/ModalEntryData';
import RegistrationRequest from '~/api/requests/RegistrationRequest';
import { getAlertModule } from '~/store';
import { RegistrationResponseType } from '~/api/responses/RegistrationResponseType';
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
export default class RegistrationModal extends Vue {
  private requestInProcess: boolean = false;
  private entryData: RegistrationEntryData = {
    pseudonym: null,
    email: null,
    password: null,
    password_confirm: null
  };

  private entryDataError = {
    pseudonym: false,
    email: false,
    password: false,
    password_confirm: false,
    confirmedPlatformRules: false
  };

  private confirmPlatformRules: boolean = false;

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

  private pseudonymEntry(event: InputEvent): void {
    this.entryData.pseudonym = (event.target as HTMLInputElement).value;
  }

  private emailEntry(event: InputEvent): void {
    this.entryData.email = (event.target as HTMLInputElement).value;
  }

  private passwordEntry(event: InputEvent): void {
    this.entryData.password = (event.target as HTMLInputElement).value;
  }

  private passwordConfirmEntry(event: InputEvent): void {
    this.entryData.password_confirm = (event.target as HTMLInputElement).value;
  }

  private get registrationRequest(): RegistrationRequest {
    return new RegistrationRequest(this.$api);
  }

  private register(): void {
    this.entryDataError.pseudonym = isEmpty(this.entryData.pseudonym);
    this.entryDataError.email = isEmpty(this.entryData.email);
    this.entryDataError.password = isEmpty(this.entryData.password);
    this.entryDataError.password_confirm = isEmpty(this.entryData.password_confirm);
    this.entryDataError.confirmedPlatformRules = isEmpty(this.confirmPlatformRules);

    if (!Object.values(this.entryDataError).includes(true)) {
      const response = this.registrationRequest.send(
        this.$config.apiClientHost as string,
        this.entryData
      );

      this.requestInProcess = true;

      response
        .then((success) => {
          this.successRegister(success.success!);
        })
        .catch((error) => {
          this.failedRegister(error.error!);
        })
        .finally(() => {
          this.requestInProcess = false;
        });
    }
  }

  private successRegister(response: RegistrationResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.register'),
      message: this.$t('alert.message.success_register', {
        email: response.data.email
      }),
      isSuccess: true,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('successRegister', response, this.entryData);

    this.close();
  }

  private failedRegister(response: ErrorResponseType): void {
    getAlertModule(this.$store).addAlert({
      title: this.$t('alert.title.register'),
      message: this.$t(response.error.message, response.error.message_parameters),
      isSuccess: false,
      autoDeleteTime: this.$config.timeForAuthDeleteDefaultAlert
    });

    this.$emit('failedRegister', response);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
