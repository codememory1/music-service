<template>
  <BaseModal ref="modal" title="modal.titles.update_playlist_directory">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_playlist_directory_title"
        :is-error="inputData.title.isError"
        @input="changeTitle"
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
import isEmpty from '~/utils/is-empty';
import { UpsertPlaylistDirectoryFormType } from '~/types/UpsertPlaylistDirectoryFormType';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton
  }
})
export default class UpdatePlaylistDirectoryModal extends Vue {
  private inputData: UpsertPlaylistDirectoryFormType = {
    title: {
      isError: false,
      value: null
    }
  };

  private create(): void {
    this.inputData.title.isError = isEmpty(this.inputData.title.value);
  }

  private changeTitle(event: InputEvent): void {
    this.inputData.title.value = (event.target as HTMLInputElement).value;
  }
}
</script>
