<template>
  <div class="uploader">
    <div
      v-if="!dragAndDropService.isMaxUploadedFiles(maxFiles)"
      ref="uploader"
      class="uploader-drag-and-drop"
      :class="{ dragenter: isDragenter }"
      @dragenter.prevent="toggleActive"
      @dragleave.prevent="toggleActive"
      @dragover.prevent
      @drop.prevent="drop"
      @click="$refs.inputFile.click()"
    >
      <input
        ref="inputFile"
        type="file"
        class="uploader-drag-and-drop__input-file"
        :multiple="maxFiles === -1 || maxFiles > 1"
        @input="changeFiles"
      />

      <div class="uploader-drag-and-drop-inner">
        <div class="uploader-drag-and-drop-info">
          <i class="uploader-drag-and-drop-info__icon fas fa-cloud-upload" />
          <p class="uploader-drag-and-drop-info__text">
            <span class="uploader-drag-and-drop-info__click-link">
              {{ $t('drag_and_drop.click_to_upload') }}
            </span>

            {{ $t('drag_and_drop.or_drag_and_drop') }}
          </p>
        </div>
      </div>
    </div>
    <div v-if="dragAndDropService.getUploadedFiles().length > 0" class="uploader-uploaded-files">
      <BaseUploadedFile
        v-for="(uploadedFile, index) in dragAndDropService.getUploadedFiles()"
        :key="index"
        :file="uploadedFile"
        @delete="dragAndDropService.removeFile(index)"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import BaseUploadedFile from '~/components/UI/FormElements/DragAndDrop/BaseUploadedFile.vue';
import DragAndDropValidationService from '~/services/ui/drag-and-drop/drag-and-drop-validation-service';
import DragAndDropService from '~/services/ui/drag-and-drop/drag-and-drop-service';

@Component({
  components: {
    BaseButton,
    BaseUploadedFile
  }
})
export default class BaseDragAndDrop extends Vue {
  @Prop({ required: false, default: 1 }) // -1 - Unlimited amount
  private readonly maxFiles!: number;

  @Prop({ required: false, default: -1 }) // -1 - Unlimited amount
  private readonly minSize!: number;

  @Prop({ required: false, default: -1 }) // -1 - Unlimited amount
  private readonly maxSize!: number;

  @Prop({ required: false, default: () => [] }) // Empty Array - Any MimeType
  private readonly allowedMimeTypes!: Array<string>;

  private readonly dragAndDropService = new DragAndDropService(this);
  private readonly dragAndDropValidationService: DragAndDropValidationService =
    new DragAndDropValidationService(this.dragAndDropService);

  private isDragenter: boolean = false;

  private changeFiles(event: PointerEvent): void {
    const files = (event.target as HTMLInputElement).files;

    for (let i = 0; i < files!.length; i++) {
      this.uploadFile(files![i]);
    }
  }

  private toggleActive(): void {
    this.isDragenter = !this.isDragenter;
  }

  private drop(event: DragEvent): void {
    this.isDragenter = false;

    const files = (event.dataTransfer as DataTransfer).items;

    for (let i = 0; i < files.length; i++) {
      this.uploadFile(files[i].getAsFile()!);
    }
  }

  private uploadFile(file: File): void {
    this.dragAndDropValidationService.addValidateNumberUploadedFiles(this.maxFiles);
    this.dragAndDropValidationService.addValidateMinSize(this.minSize, file);
    this.dragAndDropValidationService.addValidateMaxSize(this.maxSize, file);
    this.dragAndDropValidationService.addValidateMimeTypes(this.allowedMimeTypes, file);

    this.dragAndDropValidationService.validate((error) => {
      this.$store.commit('modules/alert-module/addAlert', {
        title: this.$t(error.title),
        message: this.$t(error.message, error.parameters),
        status: 'error'
      });
    });

    if (this.dragAndDropValidationService.isValidated()) {
      this.dragAndDropService.addFile(file);
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/drag-and-drop/base-drag-and-drop.scss';
</style>
