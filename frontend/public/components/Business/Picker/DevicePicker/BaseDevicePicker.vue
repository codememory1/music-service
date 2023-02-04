<template>
  <transition name="fade">
    <div v-show="show" class="device-picker">
      <h3 class="device-picker__header">{{ $t('device_picker.your_devices') }}</h3>
      <BaseDevice
        v-if="null !== authorizedUserService.currentSession"
        :session="authorizedUserService.currentSession"
        class="current"
      />

      <span role="separator" class="device-picker__separator" />

      <div class="device-picker-devices">
        <BaseDevice
          v-for="(session, index) in authorizedUserService.sessions"
          :key="index"
          :session="session"
          :selected="session.id === syncedSelectedSession"
          @click="select(session)"
        />
      </div>
    </div>
  </transition>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import BaseDevice from '~/components/Business/Picker/DevicePicker/BaseDevice.vue';
import UserSessionResponseInterface from '~/interfaces/business/api-responses/user-session-response-interface';
import AuthorizedUserService from '~/services/business/user/authorized-user-service';

@Component({
  components: {
    BaseDevice
  }
})
export default class BaseDevicePicker extends Vue {
  @Prop({ required: false, default: null })
  private readonly selectedSession!: number | null;

  private authorizedUserService!: AuthorizedUserService;
  private show: boolean = false;
  private syncedSelectedSession: number | null = this.selectedSession;

  public created(): void {
    this.authorizedUserService = new AuthorizedUserService(this);
  }

  private select(session: UserSessionResponseInterface): void {
    this.syncedSelectedSession = session.id;
  }

  public toggleShow(): void {
    this.show = !this.show;
  }

  public close(): void {
    this.show = false;
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/picker/device-picker/base-device-picker.scss';
</style>
