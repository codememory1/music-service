<template>
  <div class="uploader">
    <div
      v-if="!isMaxUploadedFiles()"
      ref="uploader"
      class="uploader-drag-and-drop"
      :class="{ dragenter: isDragenter }"
      @dragenter.prevent="toggleActive"
      @dragleave.prevent="toggleActive"
      @dragover.prevent
      @drop.prevent="drop"
      @click="clickByUploader"
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
    <div v-if="uploadedFiles.length > 0" class="uploader-uploaded-files">
      <BaseUploadedFile
        v-for="(uploadedFile, index) in uploadedFiles"
        :key="index"
        :file="uploadedFile"
        @delete="deleteFile(index)"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import BaseUploadedFile from '~/components/UI/FormElements/DragAndDrop/BaseUploadedFile.vue';
import { getAlertModule } from '~/store';
import sizeConverter from '~/utils/size-converter';

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

  private isDragenter: boolean = false;
  private uploadedFiles: Array<File> = [];

  private clickByUploader(): void {
    (this.$refs.inputFile as HTMLInputElement).click();
  }

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
    if (this.isMaxUploadedFiles()) {
      this.addErrorAlert('alert.titles.upload_files', 'alert.messages.unable_add_file_max_number', {
        max_files: this.maxFiles
      });
    } else if (this.minSize !== -1 && file.size < this.minSize) {
      const size = sizeConverter(this.minSize);

      this.addErrorAlert('alert.titles.upload_files', 'alert.messages.unable_add_file_min_size', {
        size: size.size,
        unit: size.name
      });
    } else if (this.maxSize !== -1 && file.size > this.maxSize) {
      const size = sizeConverter(this.maxSize);

      this.addErrorAlert('alert.titles.upload_files', 'alert.messages.unable_add_file_max_size', {
        size: size.size,
        unit: size.name
      });
    } else if (this.allowedMimeTypes.length !== 0 && !this.allowedMimeTypes.includes(file.type)) {
      this.addErrorAlert(
        'alert.titles.upload_files',
        'alert.messages.unable_add_file_not_allowed_mime_type',
        { mime_types: this.allowedMimeTypes.join(', ') }
      );
    } else {
      this.uploadedFiles.push(file);

      this.$emit('uploadFile', file);
    }
  }

  private deleteFile(index: number): void {
    this.uploadedFiles.splice(index, 1);
  }

  private isMaxUploadedFiles(): boolean {
    return this.maxFiles !== -1 && this.uploadedFiles.length >= this.maxFiles;
  }

  private addErrorAlert(
    titleKey: string,
    messageKey: string,
    messageParameters: object = {}
  ): void {
    getAlertModule(this.$store).addAlert({
      id: this.$uuid,
      title: this.$t(titleKey),
      message: this.$t(messageKey, messageParameters),
      status: 'error',
      autoDeleteTime: undefined
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/drag-and-drop/base-drag-and-drop.scss';
</style>
