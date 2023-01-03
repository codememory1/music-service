<template>
  <StepModal
    ref="modal"
    :steep-titles="[$t('steep_form.album.type'), $t('steep_form.album.basic_info')]"
    title="modal.titles.create_album"
    button-title="buttons.create"
    @changeWindow="changeWindow"
  >
    <ModalFormWindow v-show="activeWindow === 0">
      <BlockFormElements>
        <BaseSelect :placeholder="$t('placeholder.select_type')" :options="[]" :use-search="true" />
      </BlockFormElements>
    </ModalFormWindow>
    <ModalFormWindow v-show="activeWindow === 1">
      <BlockFormElements>
        <ModalFormInput :placeholder="$t('placeholder.enter_album_title')" />
        <ModalFormInput :placeholder="$t('placeholder.enter_album_description')" />
        <FieldModalForm :title="$t('placeholder.choose_image_file')">
          <BaseDragAndDrop />
        </FieldModalForm>
      </BlockFormElements>
    </ModalFormWindow>
  </StepModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import StepModal from '~/components/Business/Modal/StepModal.vue';
import ModalSteepForm from '~/components/UI/Form/ModalSteepForm.vue';
import BlockFormElements from '~/components/UI/Block/BlockFormElements.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';
import ModalFormWindow from '~/components/UI/Window/ModalFormWindow.vue';
import BaseDragAndDrop from '~/components/UI/FormElements/DragAndDrop/BaseDragAndDrop.vue';
import FieldModalForm from '~/components/UI/Field/FieldModalForm.vue';

@Component({
  components: {
    StepModal,
    ModalSteepForm,
    BlockFormElements,
    ModalFormInput,
    BaseSelect,
    ModalFormWindow,
    FieldModalForm,
    BaseDragAndDrop
  }
})
export default class CreateAlbumModal extends Vue {
  private activeWindow: number = 0;

  private changeWindow(index: number): void {
    this.activeWindow = index;
  }
}
</script>
