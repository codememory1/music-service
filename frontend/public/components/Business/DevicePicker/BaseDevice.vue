<template>
  <div
    class="device"
    :class="{ disabled: !device.isActive || disabled, selected: isSelected }"
    @click="$emit('click', $event)"
  >
    <div class="device-info-wrapper">
      <i class="device__icon" :class="deviceIcon" />
      <div class="device-info">
        <div class="device__name">
          {{ device.name }}#{{ device.id }} -
          <span
            class="device__status"
            :class="{ online: device.isActive, offline: !device.isActive }"
          >
            {{ device.isActive ? $t('common.status.online') : $t('common.status.offline') }}
          </span>
        </div>
        <div class="device-info-row">
          <span class="device-info-row__name">{{ $t('ip') }}:</span>
          <span class="device-info-row__value">{{ device.ip }}</span>
        </div>
        <div v-if="!device.isActive" class="device-info-row">
          <span class="device-info-row__name">{{ $t('last_activity') }}:</span>
          <span class="device-info-row__value">
            {{ device.latestActivity }}
          </span>
        </div>
      </div>
    </div>
    <div class="device-control">
      <span v-if="isSelected" class="device__selected-icon">
        <i class="far fa-check" />
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { DeviceType } from '~/types/DeviceType';
import { EnumDeviceTypes } from '~/Enums/EnumDeviceTypes';
import BaseRadiobox from '~/components/UI/Radiobox/BaseRadiobox.vue';

@Component({
  components: {
    BaseRadiobox
  }
})
export default class BaseDevice extends Vue {
  @Prop({ required: true })
  private readonly device!: DeviceType;

  @Prop({ required: false, default: false })
  private readonly disabled!: boolean;

  @Prop({ required: false, default: false })
  private readonly isSelected!: boolean;

  get deviceIcon(): string {
    switch (this.device.type) {
      case EnumDeviceTypes.Computer:
        return 'far fa-computer-speaker';
      case EnumDeviceTypes.Phone:
        return 'far fa-mobile';
      case EnumDeviceTypes.Tablet:
        return 'far fa-tablet';
      case EnumDeviceTypes.TV:
        return 'far fa-tv';
      default:
        return 'far fa-question-circle';
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/device-picker/base-device';
</style>
