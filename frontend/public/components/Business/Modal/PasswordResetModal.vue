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

      <BaseButton class="accent" @click.prevent="passwordRecovery">
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

  private passwordRecovery(): void {
    const inputCodeValue = this.validateInputCode();

    if (this.changeInputService.allFieldsWithoutErrors() && inputCodeValue.length === 6) {
      // TODO: Reset password
    }
  }

  private validateInputCode(): string {
    const inputCodeService = (this.$refs.inputCode as BaseInputCode).inputCodeService;

    inputCodeService.getSquares().forEach((square) => {
      if (square.getValue().length === 0) {
        square.setIsError(true);
      } else {
        square.setIsError(false);
      }
    });

    return inputCodeService.getValue();
  }
}
</script>
