<template>
  <BaseModal ref="modal" title="modal.titles.register">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_pseudonym"
        :is-error="inputData.pseudonym.isError"
        @input="changePseudonym"
      />
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="inputData.email.isError"
        @input="changeEmail"
      />
      <ModalNewPasswordFormInput
        placeholder="placeholder.enter_password"
        :is-error="inputData.password.isError"
        @input="changePassword"
      />
      <ModalFormInput
        type="password"
        placeholder="placeholder.enter_confirm_password"
        :is-error="inputData.confirmPassword.isError"
        @input="changePasswordConfirm"
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
import ModalFormInput from '~/components/UI/Input/ModalFormInput.vue';
import ModalNewPasswordFormInput from '~/components/UI/Input/ModalNewPasswordFormInput.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import ModalFormCheckbox from '~/components/UI/Checkbox/ModalFormCheckbox.vue';
import ModalSwitcher from '~/components/Business/Switch/ModalSwitcher.vue';
import isEmpty from '~/utils/is-empty';
import { RegisterType } from '~/types/RegisterType';

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
  private inputData: RegisterType = {
    pseudonym: {
      isError: false,
      value: null
    },
    email: {
      isError: false,
      value: null
    },
    password: {
      isError: false,
      value: null
    },
    confirmPassword: {
      isError: false,
      value: null
    },
    isAccept: {
      isError: false,
      value: false
    }
  };

  private register(): void {
    this.inputData.pseudonym.isError = isEmpty(this.inputData.pseudonym.value);
    this.inputData.email.isError = isEmpty(this.inputData.email.value);
    this.inputData.password.isError = isEmpty(this.inputData.password.value);
    this.inputData.confirmPassword.isError = isEmpty(this.inputData.confirmPassword.value);
    this.inputData.isAccept.isError = !this.inputData.isAccept.value;
  }

  private changePseudonym(event: InputEvent): void {
    this.inputData.pseudonym.value = (event.target as HTMLInputElement).value;
  }

  private changeEmail(event: InputEvent): void {
    this.inputData.email.value = (event.target as HTMLInputElement).value;
  }

  private changePassword(event: InputEvent): void {
    this.inputData.password.value = (event.target as HTMLInputElement).value;
  }

  private changePasswordConfirm(event: InputEvent): void {
    this.inputData.confirmPassword.value = (event.target as HTMLInputElement).value;
  }
}
</script>
