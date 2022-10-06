<template>
  <div class="desktop-player">
    <div class="desktop-player-control">
      <div class="desktop-player-multimedia-control">
        <BaseButton
          v-tooltip="$t('multimedia.like')"
          class="desktop-player_multimedia-control-btn desktop-player_like-btn"
        >
          <i class="fas fa-thumbs-up" />
        </BaseButton>
        <BaseButton
          v-tooltip="$t('multimedia.dislike')"
          class="desktop-player_multimedia-control-btn desktop-player_dislike-btn"
        >
          <i class="fas fa-thumbs-down" />
        </BaseButton>
        <BaseButton
          v-tooltip="$t('multimedia.add_to_media_library')"
          class="desktop-player_multimedia-control-btn desktop-player_like-btn"
        >
          <i class="fas fa-album-collection" />
        </BaseButton>
      </div>
      <div class="desktop-player-player-control">
        <BaseButton class="desktop-player_player-control-btn desktop-player_repeat-btn">
          <i class="far fa-repeat" />
        </BaseButton>
        <BaseButton class="desktop-player_player-control-btn desktop-player_prev-btn">
          <i class="fas fa-backward" />
        </BaseButton>
        <BaseButton class="desktop-player_player-control-btn desktop-player_play-pause-btn">
          <i v-if="isPlay" class="fas fa-play" />
          <i v-else class="fas fa-pause" />
        </BaseButton>
        <BaseButton class="desktop-player_player-control-btn desktop-player_next-btn">
          <i class="fas fa-forward"></i>
        </BaseButton>
        <BaseButton class="desktop-player_player-control-btn desktop-player_shuffle-btn">
          <i class="far fa-random" />
        </BaseButton>
      </div>
      <div class="desktop-player-volume-control">
        <i class="fas fa-volume-down" />
        <BaseRange class="desktop-player_volume-progress" />
        <i class="fas fa-volume" />
      </div>
    </div>
    <div class="desktop-player-time-wrapper">
      <span class="desktop-player_current-time">00:59</span>
      <BaseRange class="desktop-player_time-progress" />
      <span class="desktop-player_duration-time">02:40</span>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseButton from '~/components/UI/Button/BaseButton.vue';
import BaseRange from '~/components/UI/Range/BaseRange.vue';

@Component({
  components: {
    BaseButton,
    BaseRange
  }
})
export default class DesktopPlayer extends Vue {
  @Prop({ required: false, default: false })
  private readonly isPlay!: boolean;
}
</script>

<style lang="scss">
@import '@/assets/scss/business/player/desktop-player';
</style>
