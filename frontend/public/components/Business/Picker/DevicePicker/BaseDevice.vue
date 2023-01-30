<template>
  <div
    class="device"
    :class="{ disabled: !session.is_active, selected }"
    @click="$emit('click', $event)"
  >
    <div class="device-info-wrapper">
      <i class="device__icon" :class="deviceIcon" />
      <div class="device-info">
        <div class="device__name">
          {{ session.device }}#{{ session.id }} -
          <span
            class="device__status"
            :class="{ online: session.is_active, offline: !session.is_active }"
          >
            {{ session.is_active ? $t('statuses.online') : $t('statuses.offline') }}
          </span>
        </div>
        <div class="device-info-row">
          <span class="device-info-row__name">{{ $t('common.ip') }}:</span>
          <span class="device-info-row__value">{{ session.ip }}</span>
        </div>
        <div v-if="!session.is_active" class="device-info-row">
          <span class="device-info-row__name">{{ $t('common.last_activity') }}:</span>
          <span class="device-info-row__value">
            {{ session.last_activity }}
          </span>
        </div>
      </div>
    </div>
    <div class="device-control">
      <span v-if="selected" class="device__selected-icon">
        <i class="far fa-check" />
      </span>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import UserSessionResponseInterface from '~/interfaces/business/api-responses/user-session-response-interface';

@Component
export default class BaseDevice extends Vue {
  @Prop({ required: true })
  private readonly session!: UserSessionResponseInterface;

  @Prop({ required: false, default: false })
  private readonly selected!: boolean;

  get deviceIcon(): string {
    return 'far fa-computer-speaker'; // FIX: На бекенде во время создания сессии определить тип устройства
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/picker/device-picker/base-device.scss';
</style>
