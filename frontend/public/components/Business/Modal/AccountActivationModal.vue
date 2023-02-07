<template>
  <BaseModal ref="modal" title="modal.titles.account_activate">
    <ModalForm>
      <BaseInputCode
        ref="inputCode"
        class="sm-m-auto"
        :number-squares="6"
        pattern-value="^[0-9]+$"
      />

      <BaseButton class="accent" :is-loading="buttonIsLoading" @click.prevent="activate">
        {{ $t('buttons.activate_account') }}
      </BaseButton>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import BaseInputCode from '~/components/UI/FormElements/InputCode/BaseInputCode.vue';
import ModalNewPasswordFormInput from '~/components/UI/FormElements/Input/ModalNewPasswordFormInput.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import AccountActivationService from '~/services/business/security/account-activation-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    BaseInputCode,
    ModalNewPasswordFormInput,
    ModalFormInput,
    BaseButton
  }
})
export default class AccountActivationModal extends Vue {
  private email: string | null = null;
  private accountActivationService!: AccountActivationService;
  private buttonIsLoading: boolean = false;

  public created(): void {
    this.accountActivationService = new AccountActivationService(this);
  }

  public setEmail(email: string): void {
    this.email = email;
  }

  private async activate(): Promise<void> {
    const inputCodeService = (this.$refs.inputCode as BaseInputCode).inputCodeService;

    inputCodeService.validateSquares();

    if (inputCodeService.getValue().length === 6) {
      this.buttonIsLoading = true;

      if (this.email !== null) {
        await this.accountActivationService.activate({
          email: this.email,
          code: inputCodeService.getValue()
        });
      } else {
        this.$store.commit('modules/alert-module/addAlert', {});
      }

      this.buttonIsLoading = false;
    }
  }
}
</script>
