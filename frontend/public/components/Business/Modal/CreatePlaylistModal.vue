<template>
  <BaseModal ref="modal" title="modal.titles.create_playlist">
    <ModalForm>
      <BlockFormElements>
        <ModalFormInput :placeholder="$t('placeholder.enter_playlist_title')" />
        <FieldModalForm :title="$t('placeholder.choose_image_file')">
          <BaseUploader />
        </FieldModalForm>
        <BaseButton class="accent" @click="create">{{ $t('buttons.create') }}</BaseButton>
      </BlockFormElements>
    </ModalForm>
  </BaseModal>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseModal from '~/components/Business/Modal/BaseModal.vue';
import ModalForm from '~/components/UI/Form/ModalForm.vue';
import BlockFormElements from '~/components/UI/Block/BlockFormElements.vue';
import ModalFormInput from '~/components/UI/Input/ModalFormInput.vue';
import BaseUploader from '~/components/UI/Uploader/BaseUploader.vue';
import FieldModalForm from '~/components/UI/Field/FieldModalForm.vue';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseModal,
    ModalForm,
    BlockFormElements,
    ModalFormInput,
    FieldModalForm,
    BaseUploader,
    BaseButton
  }
})
export default class CreatePlaylistModal extends Vue {
  private create(): void {}
}
</script>
