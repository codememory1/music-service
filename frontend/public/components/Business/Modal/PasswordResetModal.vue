<template>
  <BaseModal ref="modal" :title="$t('reset_password')">
    <div class="modal-fields">
      <InputCode
        ref="code"
        :active-square-number="1"
        :count-squares="6"
        class="input-code-squares--center"
      />
      <BaseInputModal
        class="password-field"
        input-type="password"
        :placeholder="$t('enter_your_password')"
      >
        <template #up>
          <PasswordProgressBar class="above-input" />
        </template>
      </BaseInputModal>
      <BaseInputModal input-type="password" :placeholder="$t('enter_your_password_confirmation')" />
    </div>

    <BaseButton class="btn-auth button_bg--accent" @click="resetPassword">
      {{ $t('reset_password') }}
    </BaseButton>

    <div class="switch-to-another-modal-container row-grid grid-gap-5">
      <div class="security-modal__switch-to-another-modal">
        {{ $t('have_account_q') }}
        <a class="link__switch-to-another-modal" @click="$emit('openLoginModal')">
          {{ $t('login') }}
        </a>
      </div>
    </div>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue, Emit } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BaseInputModal from '~/components/UI/Input/BaseInputModal.vue';
import BaseCheckbox from '~/components/UI/Checkbox/BaseCheckbox.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/PasswordProgressBar.vue';
import InputCode from '~/components/UI/Input/InputCode.vue';

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar,
    InputCode
  }
})
export default class PasswordResetModal extends Vue {
  public open(): void {
    const modal = this.$refs.modal as BaseModal;

    modal.open();
  }

  public close(): void {
    const modal = this.$refs.modal as BaseModal;

    modal.close();
  }

  @Emit('resetPassword')
  private resetPassword(): void {
    const code = this.$refs.code as InputCode;

    code.codes.forEach((v, i) => {
      if (!/^\d+$/.test(v)) {
        code.setErrorSquare(i);
      } else {
        code.removeErrorSquare(i);
      }
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
