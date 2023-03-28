<template>
  <div class="track" @click="$emit('play')" @contextmenu.prevent="$emit('openContextMenu', $event)">
    <div class="track-num-or-play-wrapper">
      <div class="track__play">
        <i class="fal fa-play" />
      </div>
      <div class="track__number">{{ getNumber }}</div>
    </div>
    <div class="track-info-wrapper">
      <div class="track-basic-info">
        <img class="track__img" :src="data.image" :alt="data.title" />
        <div class="track-basic-text-info">
          <h4 class="track__title">{{ data.title }}</h4>
          <div class="track-basic-text-info-down">
            <MediaProfanityPart v-if="data.is_obscene_words" />
            <MediaPerformersPart
              class="track-performers"
              :card-created-at="data.created_at"
              :performers="data.performers"
            />
          </div>
        </div>
      </div>
      <div class="track-right">
        <div class="track-duration-wrapper">
          <span class="track__duration">{{ data.duration }}</span>
        </div>
        <div class="track-controls">
          <BaseButton class="track__control-btn">
            <i class="fal fa-heart" />
          </BaseButton>
          <BaseButton class="track__control-btn" @click="$emit('openContextMenu', $event)">
            <i class="fal fa-ellipsis-h-alt" />
          </BaseButton>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import TrackResponseInterface from '~/interfaces/business/api-responses/track-response-interface';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import MediaProfanityPart from '~/components/Business/MediaPart/MediaProfanityPart.vue';
import MediaPerformersPart from '~/components/Business/MediaPart/MediaPerformersPart.vue';

@Component({
  components: {
    BaseButton,
    MediaProfanityPart,
    MediaPerformersPart
  }
})
export default class BaseTrack extends Vue {
  @Prop({ required: true })
  private readonly number!: number;

  @Prop({ required: true })
  private readonly data!: TrackResponseInterface;

  private get getNumber(): string {
    return this.number < 10 ? `0${this.number}` : String(this.number);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/track/base-track.scss';
</style>
