<template>
  <BaseModal ref="modal" title="modal.titles.auth">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_email"
        :is-error="inputData.email.isError"
        @input="changeEmail"
      />
      <ModalFormInput
        type="password"
        placeholder="placeholder.enter_password"
        :is-error="inputData.password.isError"
        @input="changePassword"
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
import isEmpty from '~/utils/is-empty';
import { AuthType } from '~/types/AuthType';

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
  private inputData: AuthType = {
    email: {
      isError: false,
      value: null
    },
    password: {
      isError: false,
      value: null
    }
  };

  private auth(): void {
    this.inputData.email.isError = isEmpty(this.inputData.email.value);
    this.inputData.password.isError = isEmpty(this.inputData.password.value);
  }

  private changeEmail(event: InputEvent): void {
    this.inputData.email.value = (event.target as HTMLInputElement).value;
  }

  private changePassword(event: InputEvent): void {
    this.inputData.password.value = (event.target as HTMLInputElement).value;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/auth-modal.scss';
</style>
