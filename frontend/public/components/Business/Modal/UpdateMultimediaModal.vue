<template>
  <StepModal
    ref="modal"
    :steep-titles="[
      $t('steep_form.multimedia.basic_info'),
      $t('steep_form.multimedia.secondary_info'),
      $t('steep_form.multimedia.members')
    ]"
    title="modal.titles.update_multimedia"
    button-title="buttons.update"
    @changeWindow="changeWindow"
  >
    <ModalFormWindow v-show="activeWindow === 0">
      <BlockFormElements>
        <BaseSelect
          :placeholder="$t('placeholder.select_album')"
          :options="[]"
          :use-search="true"
        />
        <ModalFormInput :placeholder="$t('placeholder.enter_multimedia_title')" />
        <ModalFormInput :placeholder="$t('placeholder.enter_multimedia_description')" />
        <BaseSelect
          :placeholder="$t('placeholder.select_multimedia_genre')"
          :options="selectCategories"
          :use-search="true"
        />
        <FieldModalForm :title="$t('placeholder.choose_image_file')">
          <BaseDragAndDrop />
        </FieldModalForm>
      </BlockFormElements>
    </ModalFormWindow>
    <ModalFormWindow v-show="activeWindow === 1">
      <BlockFormElements>
        <ModalFormTextarea :placeholder="$t('placeholder.enter_multimedia_text')" />
        <ModalFormCheckbox :description="$t('placeholder.is_obscene_words')" />
      </BlockFormElements>
    </ModalFormWindow>
    <ModalFormWindow v-show="activeWindow === 2">
      <BlockFormElements>
        <ModalFormInput :placeholder="$t('placeholder.enter_multimedia_producer')" />
        <BaseSelect
          :placeholder="$t('placeholder.select_multimedia_performers')"
          :options="[]"
          :use-search="true"
          :as-multiple="true"
        />
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
import ModalFormTextarea from '~/components/UI/FormElements/Input/ModalFormTextarea.vue';
import BaseSelect from '~/components/UI/FormElements/Select/BaseSelect.vue';
import ModalFormWindow from '~/components/UI/Window/ModalFormWindow.vue';
import FieldModalForm from '~/components/UI/Field/FieldModalForm.vue';
import ModalFormCheckbox from '~/components/UI/FormElements/Checkbox/ModalFormCheckbox.vue';
import BaseDragAndDrop from '~/components/UI/FormElements/DragAndDrop/BaseDragAndDrop.vue';
import ApiRequestService from '~/services/business/api-request-service';
import ListMultimediaCategoryRequest from '~/api/requests/ListMultimediaCategoryRequest';
import SelectOptionType from '~/types/ui/select/select-option-type';

@Component({
  components: {
    StepModal,
    ModalSteepForm,
    BlockFormElements,
    ModalFormInput,
    ModalFormTextarea,
    BaseSelect,
    ModalFormWindow,
    FieldModalForm,
    ModalFormCheckbox,
    BaseDragAndDrop
  },

  async fetch() {
    const that = this as UpdateMultimediaModal;
    const requestService = new ApiRequestService(this);
    const listMultimediaCategoryRequest = new ListMultimediaCategoryRequest(requestService);

    await listMultimediaCategoryRequest.request();

    that.selectCategories = listMultimediaCategoryRequest.collectForSelect();
  }
})
export default class UpdateMultimediaModal extends Vue {
  private selectCategories: Array<SelectOptionType> = [];
  private activeWindow: number = 0;

  private changeWindow(index: number): void {
    this.activeWindow = index;
  }
}
</script>
