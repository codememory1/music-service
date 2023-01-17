<template>
  <BaseModal ref="modal" title="modal.titles.password_recovery">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="changeInputService.inputIsError('email')"
        @input="changeInputService.change($event, 'email')"
      />

      <BaseButton class="accent" :is-loading="buttonIsLoading" @click.prevent="passwordRecovery">
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
import ChangeInputService from '~/services/ui/input/change-input-service';
import InputService from '~/services/ui/input/input-service';
import PasswordRecoveryService from '~/services/business/security/password-recovery-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton
  }
})
export default class PasswordRecoveryModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService({
    email: new InputService('', 'string', undefined, 1)
  });

  private readonly passwordRecoveryRequest: PasswordRecoveryService = new PasswordRecoveryService(
    this
  );

  private buttonIsLoading: boolean = false;

  private async passwordRecovery(): Promise<void> {
    if (this.changeInputService.allFieldsWithoutErrors()) {
      this.buttonIsLoading = true;

      await this.passwordRecoveryRequest.recoveryRequest({
        email: this.changeInputService.getInput('email').getValue()
      });

      this.buttonIsLoading = false;
    }
  }
}
</script>
