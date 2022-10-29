<template>
  <BaseModal title="Password recovery">
    <div class="modal-fields">
      <BaseInputModal placeholder="Enter your email" />
    </div>
    <BaseButton class="btn-auth button_bg--accent">Send code</BaseButton>
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
export default class PasswordRecovery extends Vue {}
</script>

<style lang="scss">
@import '@/assets/scss/business/modal/security-modal';
</style>
