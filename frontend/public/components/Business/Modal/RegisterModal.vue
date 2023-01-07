<template>
  <BaseModal ref="modal" title="modal.titles.register">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_pseudonym"
        :is-error="inputData.pseudonym.isError"
        @input="changeInputService.change($event, inputData.pseudonym)"
      />
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="inputData.email.isError"
        @input="changeInputService.change($event, inputData.email)"
      />
      <ModalNewPasswordFormInput
        placeholder="placeholder.enter_password"
        :is-error="inputData.password.isError"
        @input="changeInputService.change($event, inputData.password)"
      />
      <ModalFormInput
        type="password"
        placeholder="placeholder.enter_confirm_password"
        :is-error="inputData.confirmPassword.isError"
        @input="changeInputService.change($event, inputData.confirmPassword)"
      />

      <ModalFormCheckbox
        v-model="inputData.isAccept.value"
        :is-error="inputData.isAccept.isError"
        :description="
          $t('confirm_action.register', {
            title: $config.title,
            terms_use_link: '/1',
            privacy_policy_link: '/2'
          })
        "
      />

      <BaseButton class="accent" @click.prevent="register">{{ $t('buttons.register') }}</BaseButton>

      <ModalSwitcher>
        {{ $t('modal.switch.have_an_account') }}
        <a @click="$emit('openLogin')">{{ $t('buttons.login') }}</a>
      </ModalSwitcher>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import ModalNewPasswordFormInput from '~/components/UI/FormElements/Input/ModalNewPasswordFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import ModalFormCheckbox from '~/components/UI/FormElements/Checkbox/ModalFormCheckbox.vue';
import ModalSwitcher from '~/components/Business/Switch/ModalSwitcher.vue';
import RegisterFormDataType from '~/types/ui/form-data/register-form-data-type';
import ChangeInputService from '~/services/ui/input/change-input-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    ModalNewPasswordFormInput,
    BaseButton,
    ModalFormCheckbox,
    ModalSwitcher
  }
})
export default class RegisterModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService();
  private inputData: RegisterFormDataType = {
    pseudonym: {
      isError: false,
      value: ''
    },
    email: {
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
    },
    isAccept: {
      isError: false,
      value: false
    }
  };

  private register(): void {
    this.inputData.pseudonym.isError = this.inputData.pseudonym.value.length === 0;
    this.inputData.email.isError = this.inputData.email.value.length === 0;
    this.inputData.password.isError = this.inputData.password.value.length === 0;
    this.inputData.confirmPassword.isError = this.inputData.confirmPassword.value.length === 0;
    this.inputData.isAccept.isError = !this.inputData.isAccept.value;
  }
}
</script>
