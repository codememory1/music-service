<template>
  <StepModal
    ref="modal"
    :steep-titles="[
      $t('steep_form.multimedia.type'),
      $t('steep_form.multimedia.basic_info'),
      $t('steep_form.multimedia.secondary_info'),
      $t('steep_form.multimedia.members')
    ]"
    title="modal.titles.add_multimedia"
    button-title="buttons.add"
    @changeWindow="changeWindow"
  >
    <ModalFormWindow v-show="activeWindow === 0">
      <BlockFormElements>
        <BaseSelect
          :placeholder="$t('placeholder.select_type')"
          :options="[
            { value: 'TRACK', title: $t('multimedia.type.track') },
            { value: 'CLIP', title: $t('multimedia.type.clip') }
          ]"
        />
      </BlockFormElements>
    </ModalFormWindow>
    <ModalFormWindow v-show="activeWindow === 1">
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
        <FieldModalForm :title="$t('placeholder.choose_media_file')">
          <BaseDragAndDrop />
        </FieldModalForm>
        <FieldModalForm :title="$t('placeholder.choose_image_file')">
          <BaseDragAndDrop />
        </FieldModalForm>
      </BlockFormElements>
    </ModalFormWindow>
    <ModalFormWindow v-show="activeWindow === 2">
      <BlockFormElements>
        <ModalFormTextarea :placeholder="$t('placeholder.enter_multimedia_text')" />
        <ModalFormCheckbox :description="$t('placeholder.is_obscene_words')" />
        <FieldModalForm :title="$t('placeholder.choose_subtitle_file')">
          <BaseDragAndDrop />
        </FieldModalForm>
      </BlockFormElements>
    </ModalFormWindow>
    <ModalFormWindow v-show="activeWindow === 3">
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
import BaseDragAndDrop from '~/components/UI/FormElements/DragAndDrop/BaseDragAndDrop.vue';
import FieldModalForm from '~/components/UI/Field/FieldModalForm.vue';
import ModalFormCheckbox from '~/components/UI/FormElements/Checkbox/ModalFormCheckbox.vue';
import ApiRequestService from '~/services/business/api-request-service';
import SelectOptionType from '~/types/ui/select/select-option-type';
import ListMultimediaCategoryRequest from '~/api/requests/list-multimedia-category-request';

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
    BaseDragAndDrop,
    ModalFormCheckbox
  },

  async fetch() {
    const that = this as AddMultimediaModal;
    const requestService = new ApiRequestService(this, this.$i18n.locale);
    const listMultimediaCategoryRequest = new ListMultimediaCategoryRequest(requestService);

    await listMultimediaCategoryRequest.request();

    that.selectCategories = listMultimediaCategoryRequest.collectForSelect();
  }
})
export default class AddMultimediaModal extends Vue {
  private selectCategories: Array<SelectOptionType> = [];
  private activeWindow: number = 0;

  private changeWindow(index: number): void {
    this.activeWindow = index;
  }
}
</script>
