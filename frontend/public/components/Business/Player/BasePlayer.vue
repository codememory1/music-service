<template>
  <div class="player">
    <div class="player-top">
      <div class="player-top-main-control">
        <BaseButton class="player-top-main-control__btn">
          <i class="fal fa-heart" />
        </BaseButton>
        <BaseButton class="player-top-main-control__btn">
          <i class="fal fa-book-heart" />
        </BaseButton>
        <div ref="devicePickerWrapper" class="relative">
          <BaseDevicePicker ref="devicePicker" />

          <BaseButton class="player-top-main-control__btn" @click="$refs.devicePicker.toggleShow()">
            <i class="fal fa-signal-stream" />
          </BaseButton>
        </div>
      </div>
      <div class="player-top-control">
        <BaseButton class="player-top-control__btn repeat">
          <i class="fal fa-repeat-alt" />
        </BaseButton>
        <BaseButton class="player-top-control__btn prev">
          <i class="fal fa-backward" />
        </BaseButton>
        <BaseButton class="accent player-top-control__btn play-pause">
          <i class="fal fa-pause" />
        </BaseButton>
        <BaseButton class="player-top-control__btn next">
          <i class="fal fa-forward" />
        </BaseButton>
        <BaseButton class="player-top-control__btn shuffle">
          <i class="fal fa-random" />
        </BaseButton>
      </div>
      <div class="player-top-volume">
        <i class="player-top-volume__icon fal fa-volume" />
        <BaseRange class="player-top-volume__range" />
        <i class="player-top-volume__icon fal fa-volume-up" />
      </div>
    </div>
    <div class="player-bottom">
      <div class="player-bottom-current-time-wrapper">
        <span class="player-bottom-current-time__text">03:33</span>
      </div>
      <div class="player-bottom-progress-time-wrapper">
        <BaseRange class="player-bottom-progress-time__range" />
      </div>
      <div class="player-bottom-duration-time-wrapper">
        <span class="player-bottom-duration-time__text">03:33</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import BaseButton from '~/components/UI/FormElements/Button/BaseButton.vue';
import BaseRange from '~/components/UI/FormElements/Range/BaseRange.vue';
import BaseDevicePicker from '~/components/Business/Picker/DevicePicker/BaseDevicePicker.vue';
import clickOut from '~/utils/click-out';

@Component({
  components: {
    BaseButton,
    BaseRange,
    BaseDevicePicker
  }
})
export default class BasePlayer extends Vue {
  public mounted(): void {
    this.clickOutDevicePicker();
  }

  public beforeDestroy(): void {
    document.removeEventListener('click', this.clickOutDevicePicker);
  }

  private clickOutDevicePicker(): void {
    clickOut(this.$refs.devicePickerWrapper as Node, (is: boolean) => {
      if (is) {
        (this.$refs.devicePicker as BaseDevicePicker).close();
      }
    });
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/player/base-player.scss';
</style>
