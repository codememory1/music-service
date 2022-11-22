<template>
  <div class="session-item-in-setting">
    <div class="session-item-in-setting-icon-wrapper">
      <i class="far fa-mobile" />
    </div>
    <div class="session-item-in-setting-info">
      <div class="session-item-in-setting-info__item">
        <span class="session-item-in-setting-info__text title white">
          {{ session.device }} ({{ session.operatingSystem }})
        </span>
        <span class="session-item-in-setting-info__text">- {{ address }}</span>
      </div>
      <div class="session-item-in-setting-info__item">
        <span class="session-item-in-setting-info__text title white">{{ session.browser }}</span>
        <span class="session-item-in-setting-info__text">
          -
          <span class="session-item-in-setting-info__text" :class="{ green: session.isActive }">
            {{ session.isActive ? ' Active now' : session.lastActivity }}
          </span>
        </span>
      </div>
      <div class="session-item-in-setting-info__item">
        <span class="session-item-in-setting-info__text title white">IP </span>
        <span class="session-item-in-setting-info__text">- {{ session.ip }}</span>
      </div>
    </div>
    <div class="session-item-in-setting-delete-button-wrapper">
      <BaseButton class="session-item-in-setting__delete-button">Delete session</BaseButton>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { SessionType } from '~/types/SessionType';
import BaseButton from '~/components/UI/Button/BaseButton.vue';

@Component({
  components: {
    BaseButton
  }
})
export default class BaseSessionItemInSetting extends Vue {
  @Prop({ required: true })
  private readonly session!: SessionType;

  private get address(): string {
    return [this.session.country, this.session.countryCode, this.session.city]
      .filter((v) => v !== null)
      .join(', ');
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/business/session/base-session-item-in-setting';
</style>
