<template>
  <BaseModal ref="modal" title="Registration">
    <div class="modal-fields">
      <BaseInputModal placeholder="Enter your pseudonym" />
      <BaseInputModal placeholder="Enter your email" />
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
    <div class="security-modal__confirm-platform-rules">
      <BaseCheckbox />
      <p class="security-modal__confirm-platform-rules__text">
        Нажимая «Зарегистрироваться» или регистрируясь через третье лицо, вы принимаете Условия
        использования Sumron-Music <a href="">и признаете Политику конфиденциальности</a>
        <a href="">и Политику использования файлов cookie</a>.
      </p>
    </div>
    <BaseButton class="btn-auth button_bg--accent">Register</BaseButton>

    <div class="switch-to-another-modal-container row-grid grid-gap-5">
      <div class="security-modal__switch-to-another-modal">
        Have an account?
        <a class="link__switch-to-another-modal" @click="$emit('openLoginModal')">Login</a>
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

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar
  }
})
export default class RegistrationModal extends Vue {
  @Emit('open')
  public open(): void {
    const modal = this.$refs.modal as BaseModal;

    modal.open();
  }

  @Emit('close')
  public close(): void {
    const modal = this.$refs.modal as BaseModal;

    modal.close();
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
