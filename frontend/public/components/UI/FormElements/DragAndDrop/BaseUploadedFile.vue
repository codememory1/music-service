<template>
  <div class="uploader-uploaded-file">
    <div class="uploader-uploaded-file__icon">
      <i class="fal fa-file-music" />
    </div>
    <div class="uploader-uploaded-file-info">
      <span class="uploader-uploaded-file__name">{{ file.name }}</span>
      <span class="uploader-uploaded-file__size">
        {{ sizeWithConvert.size.toFixed(1) }} {{ sizeWithConvert.name }}
      </span>
    </div>
    <div class="uploader-uploaded-file-close">
      <BaseButton class="uploader-uploaded-file__btn-close" @click="$emit('delete')">
        <i class="fal fa-times" />
      </BaseButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import sizeConverter, { SizeType } from '~/utils/size-converter';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseUploadedFile extends Vue {
  @Prop({ required: true })
  private readonly file!: File;

  private get sizeWithConvert(): SizeType {
    return sizeConverter(this.file.size);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/ui/form-elements/drag-and-drop/base-uploaded-file.scss';
</style>
