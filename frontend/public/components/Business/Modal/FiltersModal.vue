<template>
  <BaseModal
    ref="modal"
    class="filters-modal"
    :title="$t('common.filters')"
    :title-opposite-close="true"
  >
    <div class="filters-modal-items">
      <slot />
    </div>

    <BaseButton class="accent" @click="apply">{{ $t('buttons.apply') }}</BaseButton>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue, Emit } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import FilterItem from '~/components/Business/Item/FilterItem.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';

@Component({
  components: {
    BaseModal,
    ModalForm,
    FilterItem,
    BaseButton
  }
})
export default class FiltersModal extends Vue {
  @Emit('apply')
  private apply(): void {
    (this.$refs.modal as BaseModal).close();
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/modal/filters-modal.scss';
</style>
