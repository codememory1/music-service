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
        <div ref="devicePickerWrapper" class="relative">
          <BaseDevicePicker
            v-show="isOpenDevicePicker"
            :current-device="currentDevice"
            :devices="devices"
          />

          <BaseButton
            ref="btnToggleDevicePicker"
            v-tooltip="$t('multimedia.create_stream')"
            class="desktop-player_multimedia-control-btn desktop-player__devices"
            @click="isOpenDevicePicker = !isOpenDevicePicker"
          >
            <i class="fas fa-users-class" />
          </BaseButton>
        </div>
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
import BaseDevicePicker from '~/components/Business/DevicePicker/BaseDevicePicker.vue';
import { DeviceType } from '~/types/DeviceType';
import clickOut from '~/utils/click-out';

@Component({
  components: {
    BaseButton,
    BaseRange,
    BaseDevicePicker
  }
})
export default class DesktopPlayer extends Vue {
  @Prop({ required: false, default: false })
  private readonly isPlay!: boolean;

  private isOpenDevicePicker: boolean = false;
  private devices: Array<DeviceType> = [
    {
      id: 1,
      name: 'Mac',
      type: 'Computer',
      ip: '127.0.0.1',
      isActive: false,
      latestActivity: '2022-11-12 14:23'
    },
    {
      id: 2,
      name: 'Iphone',
      type: 'Phone',
      ip: '127.0.0.1',
      isActive: true,
      latestActivity: '2022-11-12 14:23'
    },
    {
      id: 3,
      name: 'IPad',
      type: 'Tablet',
      ip: '127.0.0.1',
      isActive: true,
      latestActivity: '2022-11-12 14:23'
    },
    {
      id: 4,
      name: 'Android TV',
      type: 'Tablet',
      ip: '127.0.0.1',
      isActive: false,
      latestActivity: '2022-11-12 14:23'
    }
  ];

  private currentDevice: DeviceType = {
    id: 5,
    name: 'IPad',
    type: 'Tablet',
    ip: '127.0.0.1',
    isActive: true,
    latestActivity: '2022-11-12 14:23'
  };

  private mounted(): void {
    this.clickOutDevicePicker();
  }

  private clickOutDevicePicker(): void {
    clickOut(this.$refs.devicePickerWrapper as Node, (is: boolean) => {
      if (is) {
        this.isOpenDevicePicker = false;
      }
    });
  }

  private beforeDestroy(): void {
    document.removeEventListener('click', this.clickOutDevicePicker);
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/player/desktop-player';
</style>
