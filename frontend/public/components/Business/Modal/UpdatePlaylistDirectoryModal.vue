<template>
  <BaseModal ref="modal" title="modal.titles.update_playlist_directory">
    <ModalForm>
      <ModalFormInput
        placeholder="placeholder.enter_playlist_directory_title"
        :is-error="changeInputService.inputIsError('title')"
        @input="changeInputService.change($event, 'title')"
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
import ChangeInputService from '~/services/ui/input/change-input-service';
import InputService from '~/services/ui/input/input-service';

@Component({
  components: {
    BaseModal,
    ModalForm,
    ModalFormInput,
    BaseButton
  }
})
export default class UpdatePlaylistDirectoryModal extends Vue {
  private readonly changeInputService: ChangeInputService = new ChangeInputService({
    title: new InputService('', 'string', undefined, 1)
  });

  private create(): void {
    if (this.changeInputService.allFieldsWithoutErrors()) {
      // TODO: Запрос на обновление директории
    }
  }
}
</script>
