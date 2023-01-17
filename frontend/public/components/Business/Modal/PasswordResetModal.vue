<template>
  <BaseModal ref="modal" title="modal.titles.password_reset">
    <ModalForm>
      <BaseInputCode
        ref="inputCode"
        class="sm-m-auto"
        :number-squares="6"
        pattern-value="^[0-9]+$"
      />
      <ModalNewPasswordFormInput
        placeholder="placeholder.enter_password"
        :is-error="changeInputService.inputIsError('password')"
        @input="changeInputService.change($event, 'password')"
      />
      <ModalFormInput
        type="password"
        name="new-password"
        placeholder="placeholder.enter_confirm_password"
        :is-error="changeInputService.inputIsError('confirmPassword')"
        @input="changeInputService.change($event, 'confirmPassword')"
      />

      <BaseButton class="accent" :is-loading="buttonIsLoading" @click.prevent="passwordRecovery">
        {{ $t('buttons.reset') }}
      </BaseButton>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import BaseInputCode from '~/components/UI/FormElements/InputCode/BaseInputCode.vue';
import ModalNewPasswordFormInput from '~/components/UI/FormElements/Input/ModalNewPasswordFormInput.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import ChangeInputService from '~/services/ui/input/change-input-service';
import InputService from '~/services/ui/input/input-service';
import PasswordResetService from '~/services/business/security/password-reset-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    BaseInputCode,
    ModalNewPasswordFormInput,
    ModalFormInput,
    BaseButton
  }
})
export default class PasswordResetModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService({
    password: new InputService('', 'string', undefined, 1),
    confirmPassword: new InputService('', 'string', undefined, 1)
  });

  private readonly passwordResetService: PasswordResetService = new PasswordResetService(this);
  private buttonIsLoading: boolean = false;
  private email: string | null = null;

  public setEmail(email: string): void {
    this.email = email;
  }

  private async passwordRecovery(): Promise<void> {
    const inputCodeService = (this.$refs.inputCode as BaseInputCode).inputCodeService;

    inputCodeService.validateSquares();

    if (
      this.changeInputService.allFieldsWithoutErrors() &&
      inputCodeService.getValue().length === 6 &&
      this.email !== null
    ) {
      this.buttonIsLoading = true;

      await this.passwordResetService.reset({
        email: this.email,
        code: inputCodeService.getValue(),
        password: this.changeInputService.getInput('password').getValue(),
        password_confirm: this.changeInputService.getInput('confirmPassword').getValue()
      });

      this.buttonIsLoading = false;
    }
  }
}
</script>
