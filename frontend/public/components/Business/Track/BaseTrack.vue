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
          <div class="track-performers">
            <span
              v-for="(performer, index) in data.performers"
              :key="index"
              class="track__performer"
            >
              <nuxt-link class="track__performer-link" to="">
                {{ performer.title }}
              </nuxt-link>
              <template v-if="index < data.performers.length - 1">&</template>
            </span>
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

@Component({
  components: {
    BaseButton
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
