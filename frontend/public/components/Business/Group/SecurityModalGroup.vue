<template>
  <div class="security-modal-group">
    <AuthModal
      ref="authModal"
      @register="
        $refs.authModal.$refs.modal.close();
        openRegisterModal();
      "
      @restorePassword="
        $refs.authModal.$refs.modal.close();
        $refs.recoveryPasswordModal.$refs.modal.open();
      "
      @successAuth="$refs.authModal.$refs.modal.close()"
      @responseSocialNetworkAuth="responseSocialNetworkAuth"
    />
    <RegisterModal
      ref="registerModal"
      @auth="
        $refs.registerModal.$refs.modal.close();
        openAuthModal();
      "
      @successRegister="successRegister"
    />
    <AccountActivationModal
      ref="accountActivationModal"
      @successActivate="
        $refs.accountActivationModal.$refs.modal.close();
        openAuthModal();
      "
    />
    <PasswordRecoveryModal
      ref="recoveryPasswordModal"
      @successRecoveryRequest="successPasswordRecoveryRequest"
      @recovery="
        $refs.recoveryPasswordModal.$refs.modal.close();
        $refs.resetPasswordModal.$refs.modal.open();
      "
    />
    <PasswordResetModal
      ref="resetPasswordModal"
      @successPasswordReset="
        $refs.resetPasswordModal.$refs.modal.close();
        openAuthModal();
      "
    />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import AuthModal from '~/components/Business/Modal/AuthModal.vue';
import RegisterModal from '~/components/Business/Modal/RegisterModal.vue';
import AccountActivationModal from '~/components/Business/Modal/AccountActivationModal.vue';
import PasswordRecoveryModal from '~/components/Business/Modal/PasswordRecoveryModal.vue';
import PasswordResetModal from '~/components/Business/Modal/PasswordResetModal.vue';
import RegisteredUserResponseInterface from '~/interfaces/business/api-responses/registered-user-response-interface';
import PasswordRecoveryResponseInterface from '~/interfaces/business/api-responses/password-recovery-response-interface';

@Component({
  components: {
    AuthModal,
    RegisterModal,
    AccountActivationModal,
    PasswordRecoveryModal,
    PasswordResetModal
  }
})
export default class SecurityModalGroup extends Vue {
  private responseSocialNetworkAuth(): void {
    const modal = (this.$refs.authModal as AuthModal).$refs.modal as BaseModal;

    modal.setIsLoading(false);

    this.$router.push({ path: '/' });

    modal.close();
  }

  private successRegister(data: RegisteredUserResponseInterface): void {
    ((this.$refs.registerModal as RegisterModal).$refs as any).modal.close();

    const accountActivationModal = this.$refs.accountActivationModal as AccountActivationModal;

    accountActivationModal.setEmail(data.email);

    (accountActivationModal.$refs as any).modal.open();
  }

  private successPasswordRecoveryRequest(data: PasswordRecoveryResponseInterface): void {
    ((this.$refs.recoveryPasswordModal as PasswordRecoveryModal).$refs as any).modal.close();

    const passwordResetModal = this.$refs.resetPasswordModal as PasswordResetModal;

    passwordResetModal.setEmail(data.user.email);

    (passwordResetModal.$refs as any).modal.open();
  }

  public openAuthModal(): void {
    ((this.$refs.authModal as AuthModal).$refs.modal as BaseModal).open();
  }

  public openRegisterModal(): void {
    ((this.$refs.registerModal as RegisterModal).$refs.modal as BaseModal).open();
  }
}
</script>
