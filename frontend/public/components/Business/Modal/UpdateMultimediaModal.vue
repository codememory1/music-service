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
          :is-loading="selectCategories.isLoading"
          :options="selectCategories.options"
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
import SelectListLoadingType from '~/types/ui/select/select-list-loading-type';
import ApiRequestService from '~/services/business/api-request-service';
import ListMultimediaCategoryResponseInterface from '~/Interfaces/business/api-responses/list-multimedia-category-response-interface';
import Routes from '~/api/routes';
import ApiSuccessResponseInterface from '~/Interfaces/business/api-success-response-interface';

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
  }
})
export default class UpdateMultimediaModal extends Vue {
  private selectCategories: SelectListLoadingType = {
    isLoading: true,
    options: []
  };

  private readonly apiRequestService: ApiRequestService<
    Array<ListMultimediaCategoryResponseInterface>
  > = new ApiRequestService(this, Routes.multimedia.category.all);

  private activeWindow: number = 0;

  private async created() {
    await this.categoryRequest();
  }

  private async categoryRequest() {
    const apiResponse = await this.apiRequestService.request();

    if (!apiResponse.isError) {
      const response = apiResponse.response as ApiSuccessResponseInterface<
        Array<ListMultimediaCategoryResponseInterface>
      >;

      response.data.forEach((category) => {
        this.selectCategories.options.push({
          value: String(category.id),
          title: category.title
        });
      });
    }

    this.selectCategories.isLoading = false;
  }

  private changeWindow(index: number): void {
    this.activeWindow = index;
  }
}
</script>
