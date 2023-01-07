<template>
  <BaseModal ref="modal" title="modal.titles.password_reset">
    <ModalForm>
      <BaseInputCode class="sm-m-auto" :number-squares="6" />
      <ModalNewPasswordFormInput
        placeholder="placeholder.enter_password"
        :is-error="inputData.password.isError"
        @input="changeInputService.change($event, inputData.password)"
      />
      <ModalFormInput
        type="password"
        name="new-password"
        placeholder="placeholder.enter_confirm_password"
        :is-error="inputData.confirmPassword.isError"
        @input="changeInputService.change($event, inputData.confirmPassword)"
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
import PasswordResetFormDataType from '~/types/ui/form-data/password-reset-form-data-type';
import ChangeInputService from '~/services/ui/input/change-input-service';

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
  private readonly changeInputService: ChangeInputService = new ChangeInputService();
  private inputData: PasswordResetFormDataType = {
    codes: {
      isError: false,
      value: ''
    },
    password: {
      isError: false,
      value: ''
    },
    confirmPassword: {
      isError: false,
      value: ''
    }
  };

  private passwordRecovery(): void {
    this.inputData.password.isError = this.inputData.password.value.length === 0;
    this.inputData.confirmPassword.isError = this.inputData.confirmPassword.value.length === 0;
  }
}
</script>
