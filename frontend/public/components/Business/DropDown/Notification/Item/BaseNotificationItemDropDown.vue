<template>
  <div class="notification-drop-down-item">
    <img
      class="notification-drop-down-item__img"
      :src="data.from.photo"
      :alt="data.from.pseudonym"
    />
    <div class="notification-drop-down-item-content">
      <div class="notification-drop-down-item__title">{{ data.title }}</div>
      <p class="notification-drop-down-item__message">
        <slot name="message" :notification="data">
          {{ data.message }}
        </slot>
      </p>
      <div class="notification-drop-down-item-date-wrapper">
        <span class="notification-drop-down-item__date">
          {{ day }} {{ $t(`common.months.${dateFromCreated.getMonth()}`) }}
          {{ dateFromCreated.getFullYear() }}
        </span>
        <span class="notification-drop-down-item__time">
          {{ dateFromCreated.getHours() }}:{{ dateFromCreated.getMinutes() }}
        </span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import UserNotificationResponseInterface from '~/interfaces/business/api-responses/user-notification-response-interface';

@Component
export default class BaseNotificationItemDropDown extends Vue {
  @Prop({ required: true })
  private readonly data!: UserNotificationResponseInterface;

  private readonly dateFromCreated: Date = new Date(this.data.created_at);

  private get day(): string {
    return this.dateFromCreated.getDay() < 10
      ? `0${this.dateFromCreated.getDay()}`
      : String(this.dateFromCreated.getDay());
  }
}
</script>

<style lang="scss">
@import '@/assets/scss/components/business/drop-down/notification/item/base-notification-item-drop-down.scss';
</style>
