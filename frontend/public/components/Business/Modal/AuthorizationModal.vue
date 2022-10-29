<template>
  <BaseModal title="Authorization">
    <div class="modal-fields">
      <BaseInputModal placeholder="Enter your email" />
      <BaseInputModal input-type="password" placeholder="Enter your password" />
    </div>
    <BaseButton class="btn-auth button_bg--accent">Login</BaseButton>

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

    <div class="security-modal__switch-to-another-modal">
      Don't know how to account?
      <a class="link__switch-to-another-modal" @click="$emit('openRegisterModal')">Register</a>
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

@Component({
  components: {
    BaseModal,
    BaseInputModal,
    BaseCheckbox,
    BaseButton,
    PasswordProgressBar
  }
})
export default class AuthorizationModal extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
@import '@/assets/scss/business/modal/auth-modal';
</style>
