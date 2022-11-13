<template>
  <BaseModal ref="modal" :title="$t('password_recovery')">
    <div class="modal-fields">
      <BaseInputModal :placeholder="$t('enter_your_email')" />
    </div>
    <BaseButton class="btn-auth button_bg--accent" @click="send">{{ $t('send_code') }}</BaseButton>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Emit, Vue } from 'vue-property-decorator';
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
export default class PasswordRecovery extends Vue {
  private send(): void {
    this.$emit('successSend');
  }

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
