<template>
  <BaseModal ref="modal" title="modal.titles.password_recovery">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="inputData.email.isError"
        @input="changeEmail"
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
import isEmpty from '~/utils/is-empty';
import { PasswordRecoveryType } from '~/types/PasswordRecoveryType';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton
  }
})
export default class PasswordRecoveryModal extends Vue {
  private inputData: PasswordRecoveryType = {
    email: {
      isError: false,
      value: null
    }
  };

  private passwordRecovery(): void {
    this.inputData.email.isError = isEmpty(this.inputData.email.value);
  }

  private changeEmail(event: InputEvent): void {
    this.inputData.email.value = (event.target as HTMLInputElement).value;
  }
}
</script>
