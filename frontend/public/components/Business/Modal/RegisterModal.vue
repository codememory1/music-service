<template>
  <BaseModal ref="modal" title="modal.titles.register">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_pseudonym"
        :is-error="changeInputService.inputIsError('pseudonym')"
        @input="changeInputService.change($event, 'pseudonym')"
      />
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="changeInputService.inputIsError('email')"
        @input="changeInputService.change($event, 'email')"
      />
      <ModalNewPasswordFormInput
        placeholder="placeholder.enter_password"
        :is-error="changeInputService.inputIsError('password')"
        @input="changeInputService.change($event, 'password')"
      />
      <ModalFormInput
        type="password"
        placeholder="placeholder.enter_confirm_password"
        :is-error="changeInputService.inputIsError('confirmPassword')"
        @input="changeInputService.change($event, 'confirmPassword')"
      />

      <ModalFormCheckbox
        v-model="changeInputService.getInput('isAccept').actualValue"
        :is-error="changeInputService.inputIsError('isAccept')"
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
        <a @click="$emit('openLogin')" @click.prevent="$emit('auth')">{{ $t('buttons.login') }}</a>
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
import ChangeInputService from '~/services/ui/input/change-input-service';
import InputService from '~/services/ui/input/input-service';

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
  private readonly changeInputService: ChangeInputService = new ChangeInputService({
    pseudonym: new InputService('', 'string', undefined, 1),
    email: new InputService('', 'string', undefined, 1),
    password: new InputService('', 'string', undefined, 1),
    confirmPassword: new InputService('', 'string', undefined, 1),
    isAccept: new InputService(false, 'boolean', true)
  });

  private register(): void {
    if (this.changeInputService.allFieldsWithoutErrors()) {
      // TODO: Registration
    }
  }
}
</script>
