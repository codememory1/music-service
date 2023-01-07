<template>
  <BaseModal ref="modal" title="modal.titles.password_recovery">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="inputData.email.isError"
        @input="changeInputService.change($event, inputData.email)"
      />

      <BaseButton class="accent" @click.prevent="passwordRecovery">
        {{ $t('buttons.send_code') }}
      </BaseButton>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import PasswordRecoveryFormDataType from '~/types/ui/form-data/password-recovery-form-data-type';
import ChangeInputService from '~/services/ui/input/change-input-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton
  }
})
export default class PasswordRecoveryModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService();
  private inputData: PasswordRecoveryFormDataType = {
    email: {
      isError: false,
      value: ''
    }
  };

  private passwordRecovery(): void {
    this.inputData.email.isError = this.inputData.email.value.length === 0;
  }
}
</script>
