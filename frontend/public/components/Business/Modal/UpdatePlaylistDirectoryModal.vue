<template>
  <BaseModal ref="modal" title="modal.titles.update_playlist_directory">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_playlist_directory_title"
        :is-error="inputData.title.isError"
        @input="changeInputService.change($event, inputData.title)"
      />
      <BaseButton class="accent" @click.prevent="create">{{ $t('buttons.update') }}</BaseButton>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import ModalFormInput from '~/components/UI/FormElements/Input/ModalFormInput.vue';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import UpsertPlaylistDirectoryFormDataType from '~/types/ui/form-data/upsert-playlist-directory-form-data-type';
import ChangeInputService from '~/services/ui/input/change-input-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton
  }
})
export default class UpdatePlaylistDirectoryModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService();
  private inputData: UpsertPlaylistDirectoryFormDataType = {
    title: {
      isError: false,
      value: ''
    }
  };

  private create(): void {
    this.inputData.title.isError = this.inputData.title.value.length === 0;
  }
}
</script>
