<template>
  <BaseModal ref="modal" title="Authorization">
    <div class="modal-fields">
      <BaseInputModal placeholder="Enter your email" @input="emailEntry" />
      <BaseInputModal
        input-type="password"
        placeholder="Enter your password"
        @input="passwordEntry"
      />
    </div>
    <BaseButton class="btn-auth button_bg--accent" @click="$emit('auth', $event)">Login</BaseButton>

    <div class="auth-from-social">
      <p class="auth-from-social__text">or via social network</p>

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
    </div>

    <div class="switch-to-another-modal-container row-grid grid-gap-5">
      <div class="security-modal__switch-to-another-modal">
        Don't know how to account?
        <a class="link__switch-to-another-modal" @click="$emit('openRegisterModal')">Register</a>
      </div>
      <div class="security-modal__switch-to-another-modal">
        Forgot your password ?
        <a class="link__switch-to-another-modal" @click="$emit('openPasswordRecoveryModal')">
          Restore password
        </a>
      </div>
    </div>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Emit, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import BaseInputModal from '~/components/UI/Input/BaseInputModal.vue';
import BaseCheckbox from '~/components/UI/Checkbox/BaseCheckbox.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import PasswordProgressBar from '~/components/UI/ProgressBar/PasswordProgressBar.vue';
import { AuthorizationEntryData } from '~/types/ModalEntryData';

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar
  }
})
export default class AuthorizationModal extends Vue {
  private data: AuthorizationEntryData = {
    email: null,
    password: null
  };

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

  private emailEntry(event: InputEvent): void {
    this.data.email = (event.target as HTMLInputElement).value;
  }

  private passwordEntry(event: InputEvent): void {
    this.data.password = (event.target as HTMLInputElement).value;
  }

  get entryData(): AuthorizationEntryData {
    return this.data;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
@import '@/assets/scss/business/modal/auth-modal';
</style>
