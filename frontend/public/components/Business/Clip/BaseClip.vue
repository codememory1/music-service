<template>
  <div class="clip">
    <div class="clip-preview-wrapper">
      <img class="clip__preview" :src="data.image" :alt="data.title" />

      <div class="clip-absolute-info-wrapper">
        <div class="clip-absolute-info-inner">
          <BaseButton class="blue clip__play-btn">
            <i class="fal fa-play" />
          </BaseButton>
          <span class="clip__duration">{{ data.duration }}</span>
        </div>
      </div>
    </div>
    <div class="clip-down-info">
      <div class="clip-title-wrapper">
        <span class="clip__title">{{ data.title }}</span>
        <BaseButton class="clip__menu-btn">
          <i class="fal fa-ellipsis-v" />
        </BaseButton>
      </div>
      <MediaPerformersPart :card-created-at="data.created_at" :performers="data.performers" />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import ClipResponseInterface from '~/interfaces/business/api-responses/clip-response-interface';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import MediaPerformersPart from '~/components/Business/MediaPart/MediaPerformersPart.vue';

@Component({
  components: {
    BaseButton,
    MediaPerformersPart
  }
})
export default class BaseClip extends Vue {
  @Prop({ required: true })
  private readonly data!: ClipResponseInterface;
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/clip/base-clip.scss';
</style>
