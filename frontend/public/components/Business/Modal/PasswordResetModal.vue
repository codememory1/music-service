<template>
  <BaseModal ref="modal" title="Password Reset">
    <div class="modal-fields">
      <InputCode :active-square-number="2" :count-squares="6" class="input-code-squares--center" />
      <BaseInputModal
        class="password-field"
        input-type="password"
        placeholder="Enter your password"
      >
        <template #up>
          <PasswordProgressBar class="above-input" />
        </template>
      </BaseInputModal>
      <BaseInputModal input-type="password" placeholder="Enter your password confirmation" />
    </div>

    <BaseButton class="btn-auth button_bg--accent">Reset the password</BaseButton>

    <div class="security-modal__switch-to-another-modal">
      Have an account?
      <a class="link__switch-to-another-modal" @click="$emit('openAuthModal')">Login</a>
    </div>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
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
  private modal!: BaseModal;

  private mounted(): void {
    this.modal = this.$refs.modal as BaseModal;
  }

  public open(): void {
    this.modal.open();
  }

  public close(): void {
    this.modal.close();
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
