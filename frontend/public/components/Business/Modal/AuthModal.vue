<template>
  <BaseModal ref="modal" title="modal.titles.auth">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="inputData.email.isError"
        @input="changeInputService.change($event, inputData.email)"
      />
      <ModalFormInput
        type="password"
        placeholder="placeholder.enter_password"
        :is-error="inputData.password.isError"
        @input="changeInputService.change($event, inputData.password)"
      />
      <BaseButton class="accent" @click.prevent="auth">{{ $t('buttons.login') }}</BaseButton>

      <p class="via-social-network-text">{{ $t('or_via_social_network') }}</p>

      <div class="auth-from-social-icons">
        <a href="" class="auth-from-social__item">
          <i class="fab fa-google" />
        </a>
        <a href="" class="auth-from-social__item">
          <i class="fab fa-facebook-f" />
        </a>
        <a href="" class="auth-from-social__item">
          <i class="fab fa-twitter" />
        </a>
      </div>

      <ModalSwitcher>
        {{ $t('modal.switch.dont_have_account') }}
        <a @click="$emit('openRegister')">{{ $t('buttons.register') }}</a>
      </ModalSwitcher>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import ModalSwitcher from '~/components/Business/Switch/ModalSwitcher.vue';
import AuthFormDataType from '~/types/ui/form-data/auth-form-data-type';
import ChangeInputService from '~/services/ui/input/change-input-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton,
    ModalSwitcher
  }
})
export default class AuthModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService();
  private inputData: AuthFormDataType = {
    email: {
      isError: false,
      value: ''
    },
    password: {
      isError: false,
      value: ''
    }
  };

  private auth(): void {
    this.inputData.email.isError = this.inputData.email.value.length === 0;
    this.inputData.password.isError = this.inputData.password.value.length === 0;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/auth-modal.scss';
</style>
