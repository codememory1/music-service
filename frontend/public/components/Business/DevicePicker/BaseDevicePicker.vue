<template>
  <transition name="fade">
    <div class="device-picker">
      <h3 class="device-picker__header">{{ $t('your_devices') }}</h3>
      <BaseDevice :device="currentDevice" class="current" />

      <hr class="device-picker__separator" />

      <div class="device-picker-devices">
        <BaseDevice
          v-for="(device, index) in devices"
          :key="index"
          :device="device"
          :is-selected="device.id === syncedActiveDevice"
          @click="select(device)"
        />
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { DeviceType } from '~/types/DeviceType';
import BaseDevice from '~/components/Business/DevicePicker/BaseDevice.vue';

@Component({
  components: {
    BaseDevice
  }
})
export default class BaseDevicePicker extends Vue {
  @Prop({ required: true })
  private readonly currentDevice!: DeviceType;

  @Prop({ required: true })
  private readonly devices!: DeviceType[];

  @Prop({ required: false, default: 0 })
  private readonly activeDevice!: number;

  private syncedActiveDevice: number = this.activeDevice;

  private select(device: DeviceType): void {
    this.syncedActiveDevice = device.id;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/device-picker/base-device-picker';
</style>
